@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\UserRole;
    use App\Models\User;

    if (Auth::check()) {
        $current = User::find(Auth::user()->id);
        $role = UserRole::find($current->user_role_id);
        $picture = $current->profile_image ? asset($current->profile_image) : asset('dashboard/dist/img/my-avatar.png');
        $hasPosts = App\Models\Post::where('user_id', Auth::id())->exists();

    } else {
        $role = null;
        $picture = asset('dashboard/dist/img/my-avatar.png');
        $hasPosts = false;
    }
@endphp

<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title', 'MeraBharat News - Daily Newspaper')</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="@yield('description', 'MeraBharat News - Daily Newspaper')">
	<meta name="keywords" content="@yield('keywords', 'MeraBharat News, daily newspaper, india news, hindi news, news portal')">
	<meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Open Graph / Twitter --}}
	<meta property="og:title" content="@yield('og_title', 'MeraBharat News - Daily Newspaper')" />
	<meta property="og:description" content="@yield('og_description', 'ਪੰਜਾਬੀ ਖ਼ਬਰਾਂ, ਲੇਖ, ਅਤੇ ਸਮਾਚਾਰ ਪੋਰਟਲ')" />
	<meta property="og:image" content="@yield('og_image', asset('images/icon.png'))" />
	<meta property="og:url" content="@yield('og_url', url()->current())" />
	<meta property="og:type" content="website" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="@yield('twitter_title', 'MeraBharat News - Daily Newspaper')" />
	<meta name="twitter:description" content="@yield('twitter_description', 'ਪੰਜਾਬੀ ਖ਼ਬਰਾਂ, ਲੇਖ, ਅਤੇ ਸਮਾਚਾਰ ਪੋਰਟਲ')" />
	<meta name="twitter:image" content="@yield('twitter_image', asset('portal/assets/img/logo/logo.png'))" />

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/icon.png') }}">

    {{-- PWA --}}
<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
<meta name="theme-color" content="#ffa600">

{{-- iOS PWA --}}
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
<link rel="apple-touch-icon" href="{{ asset('pwa/icon-192.png') }}">

<link rel="apple-touch-icon" sizes="180x180" href="/pwa/apple-icon-180.png">
<link rel="apple-touch-icon" sizes="167x167" href="/pwa/apple-icon-167.png">
<link rel="apple-touch-icon" sizes="152x152" href="/pwa/apple-icon-152.png">

    {{-- CSS files from AzNews template (public/portal/assets/...) --}}
    <link rel="stylesheet" href="{{ asset('portal/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/ticker-style.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/assets/css/style.css') }}">

    {{-- Leaflet --}}
	<link href="https://unpkg.com/leaflet/dist/leaflet.css" rel="stylesheet" />
	<link href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" rel="stylesheet" />
	<link href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" rel="stylesheet" />

    {{-- Livewire --}}
    @livewireStyles

    {{-- Page-specific head injections --}}
    @stack('head')
    @stack('styles')
</head>
<body>
    {{-- Include navigation partial (create this file and paste nav markup from template) --}}
    @includeIf('layouts.portal.nav')

    {{-- Main content from views --}}
    @yield('content')

    {{-- Include footer partial --}}
    @includeIf('layouts.portal.footer')
    <button id="btnInstall" class="btn" style="position:fixed; left:0; bottom:0; z-index:1050; font-weight:800; background-color:#198754; color:#fff; display:none;">
        <i class="bi bi-download me-2"></i> Install App
    </button>
    <div id="iosInstallHint" class="alert alert-success shadow-sm mb-0" style="display:none; position:fixed; left:20px; right:20px; bottom:20px; z-index:1050; max-width:420px;">
      <div class="d-flex align-items-center justify-content-between" style="gap:10px;">
        <span style="font-size:14px; line-height:1.3;">On iPhone, tap <strong>Share</strong> and then <strong>Add to Home Screen</strong>.</span>
        <button id="iosInstallHintDismiss" type="button" class="btn btn-sm btn-light">Close</button>
      </div>
    </div>

    {{-- JS files (load from public/portal/assets/js) --}}
    <script src="{{ asset('portal/assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/jquery.slicknav.min.js') }}"></script>

    <script src="{{ asset('portal/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/gijgo.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/animated.headline.js') }}"></script>
    <script src="{{ asset('portal/assets/js/jquery.magnific-popup.js') }}"></script>

    <script src="{{ asset('portal/assets/js/jquery.ticker.js') }}"></script>
    <script src="{{ asset('portal/assets/js/site.js') }}"></script>

    <script src="{{ asset('portal/assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/jquery.sticky.js') }}"></script>

    {{-- contact / form scripts --}}
    <script src="{{ asset('portal/assets/js/contact.js') }}"></script>
    <script src="{{ asset('portal/assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset('portal/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('portal/assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('portal/assets/js/jquery.ajaxchimp.min.js') }}"></script>

    <script src="{{ asset('portal/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('portal/assets/js/main.js') }}"></script>

    {{-- Leaflet JS --}}
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
	<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
	<script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>
	<script src="https://unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.js"></script>

    {{-- Livewire scripts --}}
    @livewireScripts

    {{-- Page-specific scripts --}}
    @stack('scripts')
<script>
  if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
      navigator.serviceWorker.register("/sw.js")
        .then((reg) => console.log("✅ SW registered:", reg.scope))
        .catch((err) => console.log("❌ SW failed:", err));
    });
  }
</script>
<script>
  let deferredPrompt;
  const iosHint = document.getElementById("iosInstallHint");
  const iosHintDismiss = document.getElementById("iosInstallHintDismiss");
  const ua = window.navigator.userAgent || "";
  const isIOS = /iPad|iPhone|iPod/.test(ua) || (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
  const isStandalone = window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone === true;

  if (isIOS && !isStandalone && iosHint) {
    iosHint.style.display = "block";
  }

  if (iosHintDismiss && iosHint) {
    iosHintDismiss.addEventListener("click", () => {
      iosHint.style.display = "none";
    });
  }

  window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    const btn = document.getElementById("btnInstall");
    if (btn) btn.style.display = "inline-flex";
  });

  document.addEventListener("click", async (e) => {
    if (e.target && (e.target.id === "btnInstall" || e.target.closest("#btnInstall"))) {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      await deferredPrompt.userChoice;
      deferredPrompt = null;
      const btn = document.getElementById("btnInstall");
      if (btn) btn.style.display = "none";
    }
  });
</script>
</body>
</html>
