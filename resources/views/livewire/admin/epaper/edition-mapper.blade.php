<div>
    <div class="grid grid-cols-12 gap-6">
        <!-- Left Sidebar - Tools -->
        <div class="col-span-2 bg-white rounded-lg shadow-sm p-4">
        <h2 class="text-lg font-semibold mb-4">Tools</h2>

        <div class="space-y-4">
            <!-- Mode Selection -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mode</label>
                <div class="space-y-2">
                    <button
                        wire:click="$set('drawMode', false)"
                        class="w-full px-3 py-2 rounded {{ !$drawMode ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }}"
                    >
                        Select
                    </button>
                    <button
                        wire:click="$set('drawMode', true)"
                        class="w-full px-3 py-2 rounded {{ $drawMode ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }}"
                    >
                        Draw Box
                    </button>
                </div>
            </div>

            <!-- Display Options -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Display</label>
                <label class="flex items-center gap-2 mb-2">
                    <input type="checkbox" wire:model.live="showOutlines" class="rounded">
                    <span class="text-sm">Show Outlines</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model.live="highlightOnHover" class="rounded">
                    <span class="text-sm">Highlight on Hover</span>
                </label>
            </div>

            <!-- Page List -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pages</label>
                <div class="space-y-1 max-h-96 overflow-y-auto">
                    @foreach($pages as $page)
                        <button
                            wire:click="selectPage({{ $page->id }})"
                            class="w-full px-3 py-2 text-left rounded text-sm {{ $currentPageId == $page->id ? 'bg-blue-500 text-white' : 'bg-gray-50 hover:bg-gray-100' }}"
                        >
                            Page {{ $page->page_no }}
                            @if($page->regions->count() > 0)
                                <span class="text-xs">({{ $page->regions->count() }})</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t">
                <button
                    wire:click="validateAndPublish"
                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-medium"
                >
                    Publish Edition
                </button>
            </div>
        </div>
    </div>

    <!-- Center - Canvas -->
    <div class="col-span-7 bg-white rounded-lg shadow-sm p-6">
        @if($currentPage)
            @livewire('admin.epaper.page-canvas', [
                'page' => $currentPage,
                'regions' => $currentPage->regions,
                'showOutlines' => $showOutlines,
                'highlightOnHover' => $highlightOnHover,
                'selectedRegionId' => $selectedRegionId
            ], key($currentPage->id))
        @else
            <div class="flex items-center justify-center h-96 text-gray-500">
                No pages available
            </div>
        @endif
    </div>

    <!-- Right Sidebar - Article Library -->
    <div class="col-span-3 bg-white rounded-lg shadow-sm p-4">
        @livewire('admin.epaper.article-library', [
            'editionId' => $editionId,
            'selectedRegionId' => $selectedRegionId
        ])
    </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</div>
