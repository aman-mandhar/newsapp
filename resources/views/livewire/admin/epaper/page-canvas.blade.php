<div class="relative" x-data="pageCanvas({
    pageId: {{ $page->id }},
    drawMode: @entangle('drawMode'),
    showOutlines: @entangle('showOutlines'),
    highlightOnHover: @entangle('highlightOnHover'),
    selectedRegionId: @entangle('selectedRegionId')
})">
    <!-- Canvas Container -->
    <div
        class="relative border rounded-lg overflow-hidden bg-gray-100"
        x-ref="container"
        @mousedown="startDraw"
        @mousemove="updateDraw"
        @mouseup="endDraw"
    >
        <!-- Page Image -->
        @if($page->image_path)
            <img
                src="{{ Storage::url($page->image_path) }}"
                alt="Page {{ $page->page_no }}"
                class="w-full h-auto block"
                x-ref="image"
            >
        @else
            <div class="flex items-center justify-center h-96 text-gray-500">
                Page image not available
            </div>
        @endif

        <!-- Existing Regions -->
        @foreach($regions as $region)
            <div
                class="absolute cursor-pointer transition-all"
                style="
                    left: {{ $region->x * 100 }}%;
                    top: {{ $region->y * 100 }}%;
                    width: {{ $region->w * 100 }}%;
                    height: {{ $region->h * 100 }}%;
                "
                @if($showOutlines)
                    x-bind:class="{
                        'border-2 border-blue-500': {{ $region->id }} !== {{ $selectedRegionId ?? 'null' }},
                        'border-4 border-green-500': {{ $region->id }} === {{ $selectedRegionId ?? 'null' }}
                    }"
                @endif
                @if($highlightOnHover)
                    x-on:mouseenter="$el.style.backgroundColor = 'rgba(59, 130, 246, 0.3)'"
                    x-on:mouseleave="$el.style.backgroundColor = selectedRegionId === {{ $region->id }} ? 'rgba(34, 197, 94, 0.2)' : 'transparent'"
                @endif
                x-bind:style="selectedRegionId === {{ $region->id }} ? 'background-color: rgba(34, 197, 94, 0.2);' : ''"
                wire:click="selectRegion({{ $region->id }})"
            >
                <!-- Region Info on Hover -->
                <div class="absolute top-0 right-0 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-bl opacity-0 hover:opacity-100">
                    @if($region->article)
                        {{ Str::limit($region->article->title, 30) }}
                    @else
                        No article
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Drawing Rectangle (temporary) -->
        <div
            x-show="drawing"
            x-ref="drawRect"
            class="absolute border-2 border-dashed border-red-500 bg-red-500 bg-opacity-20 pointer-events-none"
            style="display: none;"
        ></div>
    </div>

    <!-- Info Bar -->
    <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
        <div>
            <span class="font-medium">Page {{ $page->page_no }}</span>
            <span class="mx-2">|</span>
            <span>{{ $regions->count() }} region(s)</span>
            <span class="mx-2">|</span>
            <span>{{ $regions->where('article_id', '!=', null)->count() }} mapped</span>
        </div>
        @if($selectedRegionId)
            <button
                wire:click="$parent.deleteRegion({{ $selectedRegionId }})"
                class="text-red-600 hover:text-red-800"
            >
                Delete Selected
            </button>
        @endif
    </div>
</div>

@script
<script>
Alpine.data('pageCanvas', (config) => ({
    drawing: false,
    startX: 0,
    startY: 0,
    currentX: 0,
    currentY: 0,

    init() {
        this.$watch('selectedRegionId', (value) => {
            console.log('Selected region:', value);
        });
    },

    startDraw(e) {
        if (!this.drawMode) return;

        const rect = this.$refs.container.getBoundingClientRect();
        this.drawing = true;
        this.startX = e.clientX - rect.left;
        this.startY = e.clientY - rect.top;
        this.currentX = this.startX;
        this.currentY = this.startY;
    },

    updateDraw(e) {
        if (!this.drawing || !this.drawMode) return;

        const rect = this.$refs.container.getBoundingClientRect();
        this.currentX = e.clientX - rect.left;
        this.currentY = e.clientY - rect.top;

        // Update draw rectangle
        const drawRect = this.$refs.drawRect;
        const left = Math.min(this.startX, this.currentX);
        const top = Math.min(this.startY, this.currentY);
        const width = Math.abs(this.currentX - this.startX);
        const height = Math.abs(this.currentY - this.startY);

        drawRect.style.left = left + 'px';
        drawRect.style.top = top + 'px';
        drawRect.style.width = width + 'px';
        drawRect.style.height = height + 'px';
    },

    endDraw(e) {
        if (!this.drawing || !this.drawMode) return;

        this.drawing = false;

        const rect = this.$refs.container.getBoundingClientRect();
        const containerWidth = rect.width;
        const containerHeight = rect.height;

        const left = Math.min(this.startX, this.currentX);
        const top = Math.min(this.startY, this.currentY);
        const width = Math.abs(this.currentX - this.startX);
        const height = Math.abs(this.currentY - this.startY);

        // Minimum size check (at least 20px)
        if (width < 20 || height < 20) {
            return;
        }

        // Normalize to 0-1 range
        const normalized = {
            x: (left / containerWidth).toFixed(6),
            y: (top / containerHeight).toFixed(6),
            w: (width / containerWidth).toFixed(6),
            h: (height / containerHeight).toFixed(6)
        };

        // Emit event to Livewire
        this.$wire.createRegion(
            parseFloat(normalized.x),
            parseFloat(normalized.y),
            parseFloat(normalized.w),
            parseFloat(normalized.h)
        );
    }
}));
</script>
@endscript
