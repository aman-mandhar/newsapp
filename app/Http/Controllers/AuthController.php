<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\UserRole;
use App\Services\AuthBootstrapService;

class AuthController extends Controller
{
    /* =====================================================
     |  LOGIN PAGE
     ===================================================== */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToRoleDashboard();
        }

        return view('login');
    }

    /* =====================================================
     |  REGISTER PAGE
     ===================================================== */
    public function showRegisterForm(Request $request)
    {
        return view('register');
    }

    /* =====================================================
     |  REGISTER
     ===================================================== */
    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'mobile_number' => 'required|digits:10|unique:users,mobile_number',
            'email'         => 'nullable|email|max:255|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'location_lat'  => 'nullable|numeric',
            'location_lng'  => 'nullable|numeric',
        ]);

        // Referral user (if ref_code exists)
        $referrer = $request->filled('ref_code')
            ? User::where('ref_code', $request->ref_code)->first()
            : null;

        $email = $request->email
            ?? ($request->mobile_number . '@zedkaysuperstore.com');

        try {
            $user = User::create([
                'name'          => $request->name,
                'mobile_number' => $request->mobile_number,
                'user_role_id'  => 2,                // Customer
                'email'         => $email,
                'password'      => Hash::make($request->password),
                'location_lat'  => $request->location_lat,
                'location_lng'  => $request->location_lng,
            ]);
        } catch (\Throwable $e) {

            Log::error('User registration failed', [
                'error'     => $e->getMessage(),
                'mobile_number'    => $request->mobile_number,
                'ip'        => $request->ip(),
                'userAgent' => $request->userAgent(),
            ]);

            report($e);

            return back()
                ->withInput()
                ->with('error', 'पंजीकरण के दौरान त्रुटि हुई। कृपया पुनः प्रयास करें।');
        }

        Auth::login($user);
        // app(AuthBootstrapService::class)->run($user, $request);

        return $this->redirectToRoleDashboard()
            ->with('success', 'पंजीकरण सफल! आपका स्वागत है।');
    }

    /* =====================================================
     |  LOGIN
     ===================================================== */
    public function login(Request $request)
    {
        $request->validate([
            'mobile'   => 'required|digits:10',
            'password' => 'required|string|min:8',
            'remember' => 'nullable|boolean',
        ]);

        $user = User::where('mobile_number', $request->mobile)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Auth::login($user, (bool) $request->boolean('remember'));
            // AJAX login support
            if ($request->ajax()) {
                return response()->json([
                    'redirect_to' => route($this->redirectToRoleDashboard())
                ]);
            }

            // redirect_to parameter support
            if ($request->filled('redirect_to')) {
                return redirect()->to($request->string('redirect_to'));
            }

            return $this->redirectToRoleDashboard();
        }

        if ($request->ajax()) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return back()->with('error', 'मोबाइल नंबर या पासवर्ड गलत है।');
    }

    /* =====================================================
     |  LOGOUT
     ===================================================== */
    public function logout(Request $request)
    {
        if ($user = Auth::user()) {
            /** @var User $user */
            $user->session_token = null;
            $user->save();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        return redirect('/');
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('welcome')->with('error', 'You need to log in first.');
        }

        return $this->redirectToRoleDashboard();
    }

    protected function redirectToRoleDashboard()
    {
        $user = Auth::user();
        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        // एक ही जगह role → route का मैप
        $roleRoutes = [
            1 => 'admin.dashboard',
            2 => 'subscriber.dashboard',
            3 => 'media.dashboard',
            4 => 'employee.dashboard',
        ];

        $roleId = (int) ($user->user_role_id ?? 0);

        // अगर role match नहीं हुआ तो logout + message
        if (!isset($roleRoutes[$roleId])) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Invalid role! Logged out.');
        }

        // यदि before-login कोई intended URL था तो पहले वही
        // वरना role-based dashboard
        $fallback = route($roleRoutes[$roleId]);
        return redirect()->intended($fallback);
    }


    // Show Profile
    public function showProfile()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function Profile($id)
    {
        $user = User::findOrFail($id);
        return view('profile-view', ['user' => $user]);
    }

    // Edit Profile Form
    public function editProfile()
    {
        return view('edit_profile', [
            'user' => Auth::user(),
        ]);
    }

    // Show Change Password Form
    public function showChangePassword()
    {
        return view('change_password');
    }

    // Change Password Logic
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'  => 'required',
            'new_password'      => 'required|min:6|confirmed',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        Auth::logout();
        return redirect()->route('login')->with('success', 'Password changed. Please log in again.');
    }

    public function changeRole()
    {
        $users = User::all();
        $roles = UserRole::all();
        return view('change-role', compact('users', 'roles'));
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('mobile', 'like', "%{$query}%")
            ->paginate(10);
        $roles = UserRole::all();

        return view('change-role', compact('users', 'roles'))
            ->with('query', $query);
    }

    // change user role
    public function changeUserRole(Request $request, $id)
    {
        $request->validate([
            'user_role_id' => 'required|exists:user_roles,id',
        ]);
        $user = User::findOrFail($id);
        $user->user_role_id = $request->user_role_id;
        $user->save();
        return redirect()->back()->with('success', 'User role updated successfully.');
    }

}
