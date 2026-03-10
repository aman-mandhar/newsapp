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

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('pwa/icon-512.png') }}">

    {{-- PWA --}}
<link rel="manifest" href="{{ asset('manifest.webmanifest') }}?v=3">
<meta name="theme-color" content="#ffa600">

{{-- iOS PWA --}}
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Mera Bharat News">
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
    {{-- PWA Install Button (Android/Chrome) --}}
    <button id="btnInstall" type="button" style="position:fixed;left:0;bottom:0;z-index:1060;display:none;align-items:center;gap:8px;padding:12px 20px;background:#ffa600;color:#fff;font-weight:700;font-size:15px;border:none;border-radius:0 8px 0 0;box-shadow:2px -2px 8px rgba(0,0,0,.2);cursor:pointer;">
        <img src="/pwa/icon-192.png" alt="" style="width:28px;height:28px;border-radius:6px;">
        <span>Install Mera Bharat News</span>
        <span style="font-size:11px;opacity:.85;display:block;line-height:1;">Add to Home Screen</span>
    </button>

    {{-- iOS Install Hint --}}
    <div id="iosInstallHint" style="display:none;position:fixed;left:12px;right:12px;bottom:12px;z-index:1060;background:#fff;border:1px solid #ffa600;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.18);max-width:440px;padding:16px 18px;">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
        <img src="/pwa/icon-192.png" alt="" style="width:40px;height:40px;border-radius:10px;flex-shrink:0;">
        <div>
          <div style="font-weight:700;font-size:15px;color:#111;">Install Mera Bharat News</div>
          <div style="font-size:12px;color:#888;">Add to your Home Screen</div>
        </div>
        <button id="iosInstallHintDismiss" type="button" style="margin-left:auto;background:none;border:none;font-size:20px;color:#aaa;cursor:pointer;line-height:1;" aria-label="Close">&times;</button>
      </div>
      <p style="font-size:13px;color:#444;margin:0;">On iPhone: tap <strong>Share &#10064;</strong> &rarr; <strong>Add to Home Screen</strong>.</p>
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
    if (btn) btn.style.display = "flex";
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
