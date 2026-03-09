<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // smart role based redirect
        return $this->redirectToRoleDashboard();
    }

    public function adminDashboard()
    {
        return view('dashboards.admin');
    }

    public function subscriberDashboard()
    {
        return view('dashboards.guest');
    }

    public function mediaDashboard()
    {
        return view('dashboards.media');
    }

    public function employeeDashboard()
    {
        return view('dashboards.employee');
    }

    protected function redirectToRoleDashboard()
    {
        $role = (int) Auth::user()->user_role_id; // ensure using correct DB column

        switch ($role) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('subscriber.dashboard');
            case 3:
                return redirect()->route('media.dashboard');
            case 4:
                return redirect()->route('employee.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Invalid role! Logged out.');
        }
    }
}
