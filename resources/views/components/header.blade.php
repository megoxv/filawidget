<div class="flex items-center bg-white from-blue-500 to-indigo-500 p-6 rounded-lg shadow-md">
    <!-- Left Side: Title and Description -->
    <div class="flex-1">
        <h2 class="text-2xl font-bold mb-2">Managing dynamic content and layouts</h2>
        <p class="text-sm">Drag-and-drop interface to manage the order of widgets within each area, allowing for a fully customizable page layout without the need for coding.</p>
        <div class="flex gap-2 mt-2">
            <a href="{{ route('filament.admin.resources.widgets.index') }}" class="px-4 text-sm text-white btn-sm p-2 rounded hover:bg-blue-600" style="background: #27ae60;">
                Widgets
            </a>
            <a href="{{ route('filament.admin.resources.widget-areas.index') }}" class="px-4 text-sm text-white btn-sm p-2 rounded hover:bg-blue-600" style="background: #2980b9;">
                Widget Areas
            </a>
            <a href="{{ route('filament.admin.resources.widget-fields.index') }}" class="px-4 text-sm text-white btn-sm p-2 rounded hover:bg-blue-600" style="background: #8e44ad;">
                Fields
            </a>
            <a href="{{ route('filament.admin.resources.widget-types.index') }}" class="px-4 text-sm text-white btn-sm p-2 rounded hover:bg-blue-600" style="background: #2c3e50;">
                Widget Types
            </a>
        </div>
    </div>
    
    <!-- Right Side: Image -->
    <div class="flex-shrink-0">
        <div class="relative overflow-hidden bg-white rounded-full w-24 h-24 p-2 shadow-lg">
            <img src="https://via.placeholder.com/100" alt="Sample Image" class="w-full h-full object-cover rounded-full">
        </div>
    </div>
</div>
