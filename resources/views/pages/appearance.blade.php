<x-filament-panels::page>
    <div class="pb-4">

        @if (session('areaStatus'))
            <div class="p-3 mb-2 text-white rounded shadow" style="background: #19a5a1;">
                <div class="flex gap-4 justify-between">
                    <div>
                        {{ session('areaStatus') }}
                    </div>
                    <div wire:click="hideAlert" class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25">
                            <path d="M4.7070312 3.2929688L3.2929688 4.7070312L10.585938 12L3.2929688 19.292969L4.7070312 20.707031L12 13.414062L19.292969 20.707031L20.707031 19.292969L13.414062 12L20.707031 4.7070312L19.292969 3.2929688L12 10.585938L4.7070312 3.2929688 z" fill="#FFFDFD" />
                        </svg>
                    </div>
                </div>
            </div>
        @endif

        @if (session('widgetStatus'))
            <div class="p-3 mb-2 text-white rounded shadow" style="background: #19a5a1;">
                <div class="flex gap-4 justify-between">
                    <div>
                        {{ session('widgetStatus') }}
                    </div>
                    <div wire:click="hideAlert" class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25">
                            <path d="M4.7070312 3.2929688L3.2929688 4.7070312L10.585938 12L3.2929688 19.292969L4.7070312 20.707031L12 13.414062L19.292969 20.707031L20.707031 19.292969L13.414062 12L20.707031 4.7070312L19.292969 3.2929688L12 10.585938L4.7070312 3.2929688 z" fill="#FFFDFD" />
                        </svg>
                    </div>
                </div>
            </div>
        @endif

        <div class="fi-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between py-2 mb-2">
            <div>
                <h2 class="text-lg font-bold">Areas with their widgets</h2>
                <small>Change the order of areas and widgets just using Drag-and-drop.</small>
            </div>
            <div class="fi-ac gap-3 flex flex-wrap items-center justify-start shrink-0">
                <button wire:click="updateOrder" class="px-4 py-2 bg-primary text-white rounded hover:bg-blue-600" style="background: #19a5a1;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="25" height="25">
                        <path d="M6 4C4.895 4 4 4.895 4 6L4 24C4 25.105 4.895 26 6 26L24 26C25.105 26 26 25.105 26 24L26 8L22 4L20 4L20 10C20 10.552 19.552 11 19 11L10 11C9.448 11 9 10.552 9 10L9 4L6 4 z M 16 4L16 9L18 9L18 4L16 4 z M 10 16L20 16C21.105 16 22 16.895 22 18L22 24L8 24L8 18C8 16.895 8.895 16 10 16 z" fill="#FFFDFD" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Container for sortable items --}}
        <div id="sortable-widget-areas" class="space-y-4">
            @foreach ($widgetAreas as $key => $widgetArea)
                <div x-data="{ expanded: false }" id="sortable-container" class="sortable-widget-area-item rounded bg-white space-y-4" data-id="{{ $widgetArea->id }}">
                    <div class="fi-ta-header-toolbar flex items-center justify-between gap-x-4 px-4 py-4 sm:px-6" style="border-bottom: 1px solid #ddd;">
                        <div>
                            <p>{{ $widgetArea->name }} ({{ $widgetArea->widgets ? $widgetArea->widgets->count() : 0 }})</p>
                        </div>
                        <div @click="expanded = ! expanded" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                <path d="M7.121,17.121c-1.171,1.172-3.071,1.172-4.242,0c-1.172-1.171-1.172-3.071,0-4.242l7-7C10.465,5.293,11.232,5,12,5v7.243L7.121,17.121z" opacity=".35" />
                                <path d="M21.121,12.879C21.707,13.464,22,14.232,22,15s-0.293,1.536-0.879,2.121c-1.171,1.172-3.071,1.172-4.242,0L12,12.243V5c0.768,0,1.535,0.293,2.121,0.879L21.121,12.879z" />
                            </svg>
                        </div>
                    </div>
                    <div x-show="expanded" x-collapse id="sortable-widget-{{ $key + 1 }}" class="space-y-4 px-2 pb-4">
                        @forelse ($widgetArea->widgets as $widget)
                            <div class="sortable-widget-item bg-white p-4 rounded cursor-move" data-id="{{ $widget->id }}" style="border: 1px dashed #000;">
                                <div class="flex gap-4 justify-between">
                                    <div>
                                        {{ $widget->name }}
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                                            <path d="M15.634,3.634l-3.069-3.069c-0.312-0.312-0.819-0.312-1.131,0L8.366,3.634C7.862,4.138,8.219,5,8.931,5h6.137 C15.781,5,16.138,4.138,15.634,3.634z" />
                                            <path d="M12,9c-0.828,0-1.5-0.671-1.5-1.5v-4C10.5,2.671,11.172,2,12,2s1.5,0.671,1.5,1.5v4C13.5,8.329,12.828,9,12,9z" />
                                            <path d="M8.366,20.366l3.069,3.069c0.312,0.312,0.819,0.312,1.131,0l3.069-3.069C16.138,19.862,15.781,19,15.069,19H8.931 C8.219,19,7.862,19.862,8.366,20.366z" />
                                            <path d="M12,22c-0.828,0-1.5-0.671-1.5-1.5v-4c0-0.829,0.672-1.5,1.5-1.5s1.5,0.671,1.5,1.5v4C13.5,21.329,12.828,22,12,22z" />
                                            <path d="M7.5,10.5H5V8.931c0-0.713-0.862-1.07-1.366-0.566l-3.069,3.069c-0.312,0.312-0.312,0.819,0,1.131 l3.069,3.069C4.138,16.138,5,15.781,5,15.069V13.5h2.5C8.328,13.5,9,12.829,9,12S8.328,10.5,7.5,10.5z" opacity=".35" />
                                            <path d="M23.434,11.434l-3.069-3.069C19.862,7.862,19,8.219,19,8.931V10.5h-2.5c-0.828,0-1.5,0.671-1.5,1.5 s0.672,1.5,1.5,1.5H19v1.569c0,0.713,0.862,1.07,1.366,0.566l3.069-3.069C23.747,12.253,23.747,11.747,23.434,11.434z" opacity=".35" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="fi-ta-empty-state px-6 py-12">
                                <div class="fi-ta-empty-state-content mx-auto grid max-w-lg justify-items-center text-center">
                                    <div class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20">
                                        <svg class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                                        </svg>        
                                    </div>
                            
                                    <h4 class="fi-ta-empty-state-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                        No Widgets
                                    </h4>
                            
                                    <p class="fi-ta-empty-state-description text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Create a widget to get started.
                                    </p>
                                    
                                    <div class="fi-ta-actions flex shrink-0 items-center gap-3 flex-wrap justify-center mt-6">
                                        <a href="{{ route('filament.admin.resources.widgets.create') }}" style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">
                                            <svg class="fi-btn-icon transition duration-75 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z"></path>
                                            </svg>      
                                            <span class="fi-btn-label">
                                                Create New Widget
                                            </span>
                                        </a>
                                        <a href="{{ route('filament.admin.resources.widgets.index') }}" style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">  
                                            <svg class="fi-btn-icon transition duration-75 h-5 w-5 text-white" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path d="M7 4.5 A 2.5 2.5 0 0 0 4.5 7 A 2.5 2.5 0 0 0 7 9.5 A 2.5 2.5 0 0 0 9.5 7 A 2.5 2.5 0 0 0 7 4.5 z M 15 4.5 A 2.5 2.5 0 0 0 12.5 7 A 2.5 2.5 0 0 0 15 9.5 A 2.5 2.5 0 0 0 17.5 7 A 2.5 2.5 0 0 0 15 4.5 z M 23 4.5 A 2.5 2.5 0 0 0 20.5 7 A 2.5 2.5 0 0 0 23 9.5 A 2.5 2.5 0 0 0 25.5 7 A 2.5 2.5 0 0 0 23 4.5 z M 7 12.5 A 2.5 2.5 0 0 0 4.5 15 A 2.5 2.5 0 0 0 7 17.5 A 2.5 2.5 0 0 0 9.5 15 A 2.5 2.5 0 0 0 7 12.5 z M 15 12.5 A 2.5 2.5 0 0 0 12.5 15 A 2.5 2.5 0 0 0 15 17.5 A 2.5 2.5 0 0 0 17.5 15 A 2.5 2.5 0 0 0 15 12.5 z M 23 12.5 A 2.5 2.5 0 0 0 20.5 15 A 2.5 2.5 0 0 0 23 17.5 A 2.5 2.5 0 0 0 25.5 15 A 2.5 2.5 0 0 0 23 12.5 z M 7 20.5 A 2.5 2.5 0 0 0 4.5 23 A 2.5 2.5 0 0 0 7 25.5 A 2.5 2.5 0 0 0 9.5 23 A 2.5 2.5 0 0 0 7 20.5 z M 15 20.5 A 2.5 2.5 0 0 0 12.5 23 A 2.5 2.5 0 0 0 15 25.5 A 2.5 2.5 0 0 0 17.5 23 A 2.5 2.5 0 0 0 15 20.5 z M 23 20.5 A 2.5 2.5 0 0 0 20.5 23 A 2.5 2.5 0 0 0 23 25.5 A 2.5 2.5 0 0 0 25.5 23 A 2.5 2.5 0 0 0 23 20.5 z" fill="#FFFFFF" />
                                            </svg> 
                                            <span class="fi-btn-label">
                                                Widgets
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    {{-- Include SortableJS from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var sortable = new Sortable(document.getElementById('sortable-widget-areas'), {
                animation: 150,
                ghostClass: 'bg-blue-100',
                onEnd: function (evt) {
                    // Trigger the order update after sorting ends
                    @this.widgetAreasOrder = Array.from(document.querySelectorAll('.sortable-widget-area-item')).map(item => item.dataset.id);
                }
            });
            
            for (var i = 1; i <= 5; i++) {
                var sortable = new Sortable(document.getElementById('sortable-widget-' + i), {
                    animation: 150,
                    ghostClass: 'bg-blue-100',
                    onEnd: function (evt) {
                        // Get the sortable container's items for the current area
                        let container = evt.from;
                        let items = container.querySelectorAll('.sortable-widget-item');

                        // Update the widget order from the sorted items
                        @this.widgetsOrder = Array.from(items).map(item => item.dataset.id);
                    }
                });
            }
        });
    </script>    
</x-filament-panels::page>
