@extends('layouts.portal.view')

@section('title', 'Install App - ਲੋਕਬਾਣੀ')
@section('description', 'Install Lokbani app on your phone or desktop for a faster experience.')

@section('content')
<section class="py-5" style="background:#f8fafc; min-height:60vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h3 fw-bold mb-3">Install Lokbani App</h1>
                        <p class="text-muted mb-4">Add Lokbani to your home screen for quick access, faster loading, and app-like browsing.</p>

                        <div id="installSupported" style="display:none;">
                            <button id="installPageBtn" type="button" class="btn btn-success btn-lg fw-bold">
                                <i class="bi bi-download me-2"></i>Install Now
                            </button>
                            <p class="small text-muted mt-3 mb-0">If prompted, tap <strong>Install</strong> to finish.</p>
                        </div>

                        <div id="installNotReady" class="alert alert-light border mb-4">
                            <strong>Install button not available yet.</strong>
                            <div class="mt-2">Keep browsing this site for a moment, then come back to this page. Some browsers show install only after engagement.</div>
                        </div>

                        <div class="alert alert-success mb-0">
                            <strong>iPhone / iPad:</strong> Open this site in Safari, tap <strong>Share</strong>, then <strong>Add to Home Screen</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    #btnInstall {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    let installPromptEvent = null;

    const installSupported = document.getElementById('installSupported');
    const installNotReady = document.getElementById('installNotReady');
    const installPageBtn = document.getElementById('installPageBtn');

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        installPromptEvent = e;

        if (installSupported) installSupported.style.display = 'block';
        if (installNotReady) installNotReady.style.display = 'none';
    });

    if (installPageBtn) {
        installPageBtn.addEventListener('click', async function () {
            if (!installPromptEvent) return;
            installPromptEvent.prompt();
            await installPromptEvent.userChoice;
            installPromptEvent = null;
            installPageBtn.style.display = 'none';
        });
    }
</script>
@endpush
