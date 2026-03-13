{{-- resources/views/about.blade.php --}}
@extends('layouts.portal.view')

@section('ਲੋਕਬਾਣੀ - Lokbani')
@section('description', 'ਲੋਕਬਾਣੀ - ਪੰਜਾਬੀ ਖ਼ਬਰਾਂ, ਲੇਖ, ਅਤੇ ਸਮਾਚਾਰ ਪੋਰਟਲ। ਤਾਜ਼ਾ ਖ਼ਬਰਾਂ, ਸਿੱਖ ਧਰਮ, ਸੱਭਿਆਚਾਰ, ਅਤੇ ਸਮਾਜਿਕ ਮੁੱਦਿਆਂ ਬਾਰੇ ਜਾਣਕਾਰੀ।')

@section('content')
<section class="kv-about-hero">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <h1 class="kv-title">About us</h1>
                <p class="kv-lead">
                    Tagline
                </p>

                <div class="kv-stats d-flex flex-wrap gap-2">
                    <span class="kv-chip"><i class="fa-solid fa-pen-nib me-2"></i> 10+ Years</span>
                    <span class="kv-chip"><i class="fa-solid fa-calendar-check me-2"></i> Started in : 2010</span>
                    <span class="kv-chip"><i class="fa-solid fa-users-viewfinder me-2"></i> ~10 Visitors</span>
                    <span class="kv-chip"><i class="fa-solid fa-user-plus me-2"></i> 13,500+ Subscriber</span>
                </div>

                <hr class="my-4">

                {{-- Core narrative --}}
                <article class="kv-copy">
                    <p>
                        About Organization and Editor
                    </p>
                </article>
            </div>

            {{-- Quick facts / side card --}}
            <aside class="col-lg-4">
                <div class="kv-aside card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Quick View</h5>
                        <ul class="kv-factlist">
                            <li><i class="fa-solid fa-user-tie me-2"></i> Editor : Vikas Modgil</li>
                            <li><i class="fa-solid fa-newspaper me-2"></i> RNI Registered Daily Edition</li>
                            <li><i class="fa-solid fa-tv me-2"></i> Mera Bharat Newspaper and Portal</li>
                        </ul>
                        <a href="{{ url('/') }}" class="btn btn-primary w-100 mt-2">Back to Home</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* ---- About page styles (Bootstrap 5+) ---- */
.kv-about-hero{ padding: 2rem 0 3rem; background:#f8fafc; }
.kv-title{
  font-weight:800; letter-spacing:.2px; margin-bottom:.5rem;
}
.kv-lead{
  font-size:1.05rem; color:#334155; margin-bottom:1rem;
}
.kv-stats .kv-chip{
  display:inline-flex; align-items:center; padding:.4rem .75rem;
  background:#fff; border:1px solid #e5e7eb; border-radius:9999px;
  font-weight:600; color:#0f172a;
}
.kv-copy p{
  color:#0f172a; line-height:1.85; margin-bottom:1rem;
  word-break: break-word;
}
.kv-aside .card-title{ font-weight:700; }
.kv-factlist{
  list-style:none; padding:0; margin:0;
}
.kv-factlist li{
  padding:.5rem 0; border-bottom:1px dashed #e5e7eb; color:#0f172a;
}
.kv-factlist li:last-child{ border-bottom:0; }

@media (max-width: 991.98px){
  .kv-about-hero{ padding:1.25rem 0 2rem; }
}
</style>
@endpush
