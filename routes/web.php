<?php

use App\Http\Controllers\Admin\EpaperEditionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EpaperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VideoLinkController;
use Illuminate\Support\Facades\Route;

Route::view('/offline', 'offline')->name('offline');

// ---------------------------
// Public Routes
// ---------------------------
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/home', [HomeController::class, 'home'])->name('home.index');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::view('/install', 'install')->name('install');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-post', [HomeController::class, 'searchPost'])->name('search-post');

Route::get('/api/youtube/gallery', [\App\Http\Controllers\YouTubeGalleryController::class, 'index']);

// ---------------------------
// E-Paper Routes
// ---------------------------
Route::get('/epaper/today', [EpaperController::class, 'today'])->name('epaper.today');

// ---------------------------
// Auth Routes (Guest only)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Dashboard - Smart role-based redirect (Authenticated only)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->middleware('auth')->name('admin.dashboard');
Route::get('/subscriber/dashboard', [DashboardController::class, 'subscriberDashboard'])->middleware('auth')->name('subscriber.dashboard');
Route::get('/media/dashboard', [DashboardController::class, 'mediaDashboard'])->middleware('auth')->name('media.dashboard');
Route::get('/employee/dashboard', [DashboardController::class, 'employeeDashboard'])->middleware('auth')->name('employee.dashboard');

// Profile routes (AuthController - Custom portal profile)
Route::get('/my-profile', [AuthController::class, 'showProfile'])->name('profile.show');
Route::get('/profile/{id}', [AuthController::class, 'Profile'])->name('profile.view');
Route::get('/my-profile/edit', [AuthController::class, 'editProfile'])->name('auth.profile.edit');
// Route::post('/my-profile/update', [AuthController::class, 'updateProfile'])->name('auth.profile.update');

// Logout (Authenticated only)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ---------------------------
// Posts Create Route - MUST come BEFORE /posts/{post}
// ---------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

// ---------------------------
// Public Posts Routes - Wildcard routes come AFTER specific routes
// ---------------------------
Route::get('/posts', [PostController::class, 'portalNews'])->name('posts.all');
Route::get('/posts/{post}/single-layout', [PostController::class, 'singleLayout'])->name('single-layout');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// ---------------------------
// Public Category & Tag Routes
// ---------------------------

Route::get('/category/{category}', [NewsCategoryController::class, 'CatPost'])->name('categories.posts');
Route::get('/news-category/{category:slug}', [NewsCategoryController::class, 'CatPost'])->name('news-category.show');
Route::get('/tag/{tag}', [TagController::class, 'show'])->name('tags.show.public');

// ---------------------------
// Authenticated user routes
// ---------------------------
Route::middleware(['auth'])->group(function () {
    // Dashboard - Smart role-based redirect
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role-specific dashboard routes
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/promoter/dashboard', [DashboardController::class, 'promoterDashboard'])->name('promoter.dashboard');
    Route::get('/pro/dashboard', [DashboardController::class, 'proDashboard'])->name('pro.dashboard');
    Route::get('/guest/dashboard', [DashboardController::class, 'guestDashboard'])->name('guest.dashboard');

    // Profile routes (AuthController - Custom portal profile)
    Route::get('/my-profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/{id}', [AuthController::class, 'Profile'])->name('profile.view');
    Route::get('/my-profile/edit', [AuthController::class, 'editProfile'])->name('auth.profile.edit');
    Route::post('/my-profile/update', [AuthController::class, 'updateProfile'])->name('auth.profile.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password management
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');

    // Role management (Admin only)
    Route::get('/change-role', [AuthController::class, 'changeRole'])->name('role.change');
    Route::get('/search-user', [AuthController::class, 'searchUser'])->name('user.search');
    Route::post('/change-user-role/{id}', [AuthController::class, 'changeUserRole'])->name('user.role.update');

    // Media Management (Images & Videos) - Polymorphic for all models
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [ImageController::class, 'index'])->name('index');
        // Images
        Route::get('images/create', [ImageController::class, 'create'])->name('images.create');
        Route::post('images', [ImageController::class, 'store'])->name('images.store');
        Route::delete('images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');

        // Video Links
        Route::get('videos/create', [VideoLinkController::class, 'create'])->name('videos.create');
        Route::post('videos', [VideoLinkController::class, 'store'])->name('videos.store');
        Route::delete('videos/{id}', [VideoLinkController::class, 'destroy'])->name('videos.destroy');
    });

    // Admin area (secured by auth - further checks can be added via middleware/policies)
    Route::prefix('admin')->name('admin.')->group(function () {
        // Posts (CRUD)
        Route::get('posts', [PostController::class, 'index'])->name('posts.index');
        Route::post('posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        // Posts draft edit (custom)
        Route::get('posts/{post}/draft-edit', [PostController::class, 'draftEdit'])->name('posts.draft-edit');

        // Category CRUD
        Route::resource('categories', NewsCategoryController::class)->names([
            'index' => 'categories.index',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'show' => 'categories.show',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'destroy' => 'categories.destroy',
        ]);

        // Tags CRUD
        Route::resource('tags', TagController::class)->names([
            'index' => 'tags.index',
            'create' => 'tags.create',
            'store' => 'tags.store',
            'show' => 'tags.show',
            'edit' => 'tags.edit',
            'update' => 'tags.update',
            'destroy' => 'tags.destroy',
        ]);

        // Comments admin
        Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
        Route::get('comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
        Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        // ePaper Editions
        Route::prefix('epaper/editions')->name('epaper.editions.')->group(function () {
            Route::get('/', [EpaperEditionController::class, 'index'])->name('index');
            Route::get('create', [EpaperEditionController::class, 'create'])->name('create');
            Route::post('/', [EpaperEditionController::class, 'store'])->name('store');
            Route::get('{edition}', [EpaperEditionController::class, 'show'])->name('show');
            Route::get('{edition}/edit', [EpaperEditionController::class, 'edit'])->name('edit');
            Route::put('{edition}', [EpaperEditionController::class, 'update'])->name('update');
            Route::delete('{edition}', [EpaperEditionController::class, 'destroy'])->name('destroy');
            Route::get('{edition}/mapper', [EpaperEditionController::class, 'mapper'])->name('mapper');
        });
    });
});

Route::post('/tinymce/upload', [App\Http\Controllers\TinyMCEController::class, 'upload'])->name('tinymce.upload');
