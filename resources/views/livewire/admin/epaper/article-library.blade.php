<div class="h-full flex flex-col">
    <h2 class="text-lg font-semibold mb-4">Article Library</h2>

    <!-- Flash Messages -->
    @if (session()->has('article-success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">
            {{ session('article-success') }}
        </div>
    @endif

    @if (session()->has('article-error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
            {{ session('article-error') }}
        </div>
    @endif

    <!-- Selected Region Info -->
    @if($selectedRegionId)
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded text-sm">
            <p class="font-medium text-blue-900">Region Selected</p>
            <p class="text-blue-700 text-xs">Click an article to attach</p>
        </div>
    @else
        <div class="mb-4 p-3 bg-gray-50 border border-gray-200 rounded text-sm text-gray-600">
            Select a region to attach an article
        </div>
    @endif

    <!-- Search -->
    <div class="mb-4">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Search articles..."
            class="w-full px-3 py-2 border rounded-lg text-sm"
        >
    </div>

    <!-- New Article Button -->
    <button
        wire:click="openNewArticleModal"
        class="w-full mb-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-medium text-sm"
    >
        + New Article
    </button>

    <!-- Articles List -->
    <div class="flex-1 overflow-y-auto space-y-2">
        @forelse($articles as $article)
            <div class="border rounded-lg p-3 hover:bg-gray-50 cursor-pointer group">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-sm truncate">{{ $article->title }}</h3>
                        @if($article->section)
                            <p class="text-xs text-gray-500 mt-1">{{ $article->section }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ Str::limit($article->body, 60) }}</p>
                    </div>
                    @if($selectedRegionId)
                        <button
                            wire:click="attachArticle({{ $article->id }})"
                            class="ml-2 px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity"
                        >
                            Attach
                        </button>
                    @endif
                </div>

                <!-- Show if already used -->
                @if($article->regions->isNotEmpty())
                    <div class="mt-2 text-xs text-blue-600">
                        Used in {{ $article->regions->count() }} region(s)
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center text-gray-500 text-sm py-8">
                No articles found
            </div>
        @endforelse
    </div>

    <!-- New Article Modal -->
    @if($showNewArticleModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click.self="closeNewArticleModal">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold">Create New Article</h3>
                        <button wire:click="closeNewArticleModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="createArticle">
                        <div class="space-y-4">
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                                <input
                                    type="text"
                                    wire:model="newArticleTitle"
                                    class="w-full px-3 py-2 border rounded-lg"
                                    required
                                >
                                @error('newArticleTitle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Section -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                                <input
                                    type="text"
                                    wire:model="newArticleSection"
                                    class="w-full px-3 py-2 border rounded-lg"
                                    placeholder="e.g., News, Sports, Opinion"
                                >
                                @error('newArticleSection')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Body -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Body *</label>
                                <textarea
                                    wire:model="newArticleBody"
                                    rows="6"
                                    class="w-full px-3 py-2 border rounded-lg"
                                    required
                                ></textarea>
                                @error('newArticleBody')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                                <button
                                    type="button"
                                    wire:click="closeNewArticleModal"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg"
                                >
                                    Create Article
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
