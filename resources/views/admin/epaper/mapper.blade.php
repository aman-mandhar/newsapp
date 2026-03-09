<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Edition - {{ $edition->edition_name }}</title>
    @php($hasViteManifest = file_exists(public_path('build/manifest.json')))
    @if($hasViteManifest)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif
    @livewireStyles
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-full mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $edition->edition_name }}</h1>
                        <p class="text-sm text-gray-600">{{ $edition->issue_date->format('d M Y') }} - Map Hotspots</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                            ← Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-full mx-auto px-4 py-6">
            @livewire('admin.epaper.edition-mapper', ['editionId' => $edition->id])
        </main>
    </div>

    @livewireScripts
</body>
</html>
