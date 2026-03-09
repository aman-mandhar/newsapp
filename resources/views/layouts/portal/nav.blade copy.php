<header class="site-header">
  <!-- Skip link for keyboard users -->
  <a class="skip-link" href="#main-content">Skip to content</a>

  <!-- Header Top (weather + date + social) -->
  <div class="header-top">
    <div class="container header-top__inner">
      <div class="header-top__left" aria-hidden="false">
        <ul class="meta-list">
          <li class="meta-item">
            <img src="assets/img/icon/header_icon1.png" alt="" aria-hidden="true">
            <span class="weather" aria-live="polite">34ºC, Sunny</span>
          </li>
          <li class="meta-item">
            <img src="assets/img/icon/header_icon1.png" alt="" aria-hidden="true">
            <time datetime="2019-06-18">Tuesday, 18th June, 2019</time>
          </li>
        </ul>
      </div>

      <div class="header-top__right">
        <ul class="social-list" aria-label="Social links">
          <li><a href="#" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
          <li><a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
          <li><a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Header Middle (logo + tagline) -->
  <div class="header-mid">
    <div class="container header-mid__inner">
      <div class="brand">
        <a href="index.html" class="brand__kv">
          <img src="{{ asset('images/kv_logo.png') }}" width="90" height="90" alt="KV badge">
        </a>

        <a href="index.html" class="brand__main" aria-label="Homepage">
          <img src="{{ asset('images/logo.png') }}" height="90" alt="Site logo">
        </a>
      </div>

      <div class="header-banner--ad" aria-hidden="true">
        <!-- placeholder for banner / ad -->
      </div>
    </div>
  </div>

  <!-- Header Bottom (nav + search + mobile) -->
  <div class="header-bottom">
    <div class="container header-bottom__inner">
      <div class="header-left">
        <!-- Sticky logo (revealed on scroll via CSS/JS if desired) -->
        <div class="sticky-logo">
          <a href="index.html"><img src="{{ asset('images/logo.png') }}" width="150" alt="logo"></a>
        </div>

        <!-- Main navigation (single unique id) -->
        <nav id="main-navigation" class="main-nav" role="navigation" aria-label="Main navigation">
          <button id="mobile-menu-toggle" class="mobile-toggle" aria-expanded="false" aria-controls="main-navigation-list">
            <span class="sr-only">Toggle navigation</span>
            <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>

          <ul id="main-navigation-list" class="main-nav__list">
            <li class="nav-item"><a href="index.html">Home</a></li>
            <li class="nav-item"><a href="categori.html">Category</a></li>
            <li class="nav-item"><a href="about.html">About</a></li>
            <li class="nav-item"><a href="latest_news.html">Latest News</a></li>
            <li class="nav-item"><a href="contact.html">Contact</a></li>

            <li class="nav-item nav-item--has-submenu" aria-haspopup="true">
              <a href="#" class="submenu-toggle" aria-expanded="false">Pages</a>
              <ul class="submenu" role="menu" aria-label="Pages submenu">
                <li role="none"><a role="menuitem" href="elements.html">Element</a></li>
                <li role="none"><a role="menuitem" href="blog.html">Blog</a></li>
                <li role="none"><a role="menuitem" href="single-blog.html">Blog Details</a></li>
                <li role="none"><a role="menuitem" href="details.html">Category Details</a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>

      <div class="header-right">
        <div class="header-search">
          <button id="search-toggle" class="search-toggle" aria-expanded="false" aria-controls="search-box">
            <i class="fas fa-search" aria-hidden="true"></i><span class="sr-only">Open search</span>
          </button>
          <div id="search-box" class="search-box" aria-hidden="true">
            <form action="#" role="search" method="get">
              <label for="header-search-input" class="sr-only">Search</label>
              <input id="header-search-input" type="search" name="s" placeholder="Search" />
              <button type="submit" class="search-submit">Go</button>
            </form>
          </div>
        </div>
      </div>
    </div> <!-- .container -->
  </div>

  <!-- Mobile menu container (slides in) -->
  <div id="mobile-menu-panel" class="mobile-menu-panel" aria-hidden="true">
    <!-- We'll clone the main menu here via JS for a better mobile UX -->
  </div>
</header>

<!-- Minimal UI-focused CSS (put in your main CSS file instead of inline) -->
<style>
  /* Utility / accessibility */
  .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
  .skip-link { position: absolute; left: -9999px; top: auto; background:#111; color:#fff; padding:8px 12px; z-index:999; }
  .skip-link:focus { left: 10px; top: 10px; }

  /* Layout */
  .container { max-width: 1200px; margin: 0 auto; padding: 0 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; }
  .header-top, .header-mid, .header-bottom { background:#fff; border-bottom:1px solid #eee; }
  .header-top__inner { display:flex; justify-content:space-between; align-items:center; padding:8px 0; }
  .meta-list, .social-list { list-style:none; margin:0; padding:0; display:flex; gap:12px; align-items:center; }
  .meta-item { display:flex; gap:8px; align-items:center; font-size:0.95rem; color:#333; }

  .brand { display:flex; gap:18px; align-items:center; }
  .brand__kv img { border-radius:6px; }

  .main-nav__list { list-style:none; margin:0; padding:0; display:flex; gap:18px; align-items:center; }
  .nav-item a { text-decoration:none; color:#222; padding:10px 6px; display:inline-block; }
  .nav-item--has-submenu { position:relative; }
  .submenu { position:absolute; left:0; top:100%; background:#fff; border:1px solid #eee; padding:8px 0; min-width:200px; display:none; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
  .submenu li a { padding:8px 16px; display:block; }

  /* Search */
  .search-box { display:none; position:relative; }
  .search-box input { padding:8px 10px; border:1px solid #ddd; border-radius:4px; width:200px; }
  .search-submit { margin-left:8px; padding:8px 10px; }

  /* Mobile */
  .mobile-toggle { display:none; background:none; border:0; cursor:pointer; }
  .mobile-menu-panel { display:none; }

  /* Responsive */
  @media (max-width: 991px) {
    .main-nav__list { display:none; }
    .mobile-toggle { display:inline-flex; }
    .search-box input { width:140px; }
    .mobile-menu-panel { display:block; position:fixed; left:0; top:0; right:0; bottom:0; background:#fff; z-index:1000; transform:translateY(-100%); transition:transform .28s ease; overflow:auto; padding:20px; }
    .mobile-menu-panel.open { transform:translateY(0); }
    .header-top__inner, .header-mid__inner, .header-bottom__inner { padding:10px 0; }
  }

  /* Hover (desktop) */
  .nav-item--has-submenu:hover .submenu { display:block; }
</style>

<!-- Minimal UI JS (put in external file in production) -->
<script>
  (function(){
    // mobile nav toggle + clone desktop menu into mobile panel
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobilePanel = document.getElementById('mobile-menu-panel');
    const mainList = document.getElementById('main-navigation-list');

    mobileToggle && mobileToggle.addEventListener('click', function(){
      const expanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', !expanded);
      mobilePanel.classList.toggle('open');
      mobilePanel.setAttribute('aria-hidden', expanded);
      // clone menu only once
      if (!mobilePanel.dataset.cloned) {
        const clone = mainList.cloneNode(true);
        clone.id = 'mobile-menu-list';
        clone.querySelectorAll('.submenu').forEach(s => s.style.position='static');
        mobilePanel.appendChild(clone);
        mobilePanel.dataset.cloned = '1';
      }
    });

    // submenu toggles (keyboard + mobile)
    document.querySelectorAll('.nav-item--has-submenu > .submenu-toggle').forEach(btn => {
      btn.addEventListener('click', function(e){
        e.preventDefault();
        const expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !expanded);
        const submenu = this.nextElementSibling;
        if (submenu) submenu.style.display = expanded ? 'none' : 'block';
      });
    });

    // search toggle
    const searchToggle = document.getElementById('search-toggle');
    const searchBox = document.getElementById('search-box');
    searchToggle && searchToggle.addEventListener('click', function(){
      const expanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', !expanded);
      if (searchBox) {
        const show = !expanded;
        searchBox.style.display = show ? 'block' : 'none';
        searchBox.setAttribute('aria-hidden', !show);
        if (show) document.getElementById('header-search-input').focus();
      }
    });

    // close mobile panel on Escape
    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape') {
        if (mobilePanel.classList.contains('open')) {
          mobilePanel.classList.remove('open');
          mobileToggle.setAttribute('aria-expanded', 'false');
          mobilePanel.setAttribute('aria-hidden','true');
        }
        if (searchBox && searchBox.style.display === 'block') {
          searchBox.style.display = 'none';
          searchToggle.setAttribute('aria-expanded','false');
          searchBox.setAttribute('aria-hidden','true');
        }
      }
    });
  })();
</script>
