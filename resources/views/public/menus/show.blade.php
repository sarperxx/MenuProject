{{-- resources/views/public/menus/show.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $menu->name }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto py-10">
        <a href="{{ route('public.menus.index') }}" class="text-blue-500 hover:underline text-sm mb-4 inline-block">&larr; Back to all menus</a>
        <h1 class="text-3xl font-bold mb-2 text-blue-700">{{ $menu->name }}</h1>
        <div class="flex items-center text-gray-500 mb-4">
            <span class="mr-2">{{ $menu->start_time }} - {{ $menu->end_time }}</span>
        </div>
        @if ($menu->description)
            <p class="text-gray-600 mb-6">{{ $menu->description }}</p>
        @endif

        <!-- Allergen Filter Section -->
        @if($showAllergenFilter)
        <div class="mb-8 bg-white rounded-lg shadow p-4 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Exclude Allergens</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($allergens as $allergen)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" 
                               class="allergen-filter" 
                               value="{{ $allergen->id }}" 
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">{{ $allergen->name }}</span>
                    </label>
                @endforeach
            </div>
            <button id="clear-filters" class="mt-3 text-sm text-blue-600 hover:text-blue-800 underline">Clear all filters</button>
        </div>
        @endif

        @foreach ($menu->categories as $category)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-2 border-b pb-1">{{ $category->name }}</h2>
                @if ($category->menuItems->count() > 0)
                    <ul class="space-y-4">
                        @foreach ($category->menuItems as $item)
                            <li class="menu-item bg-white rounded-lg shadow p-4 border border-gray-100" 
                                data-allergens="{{ $item->allergens->pluck('id')->implode(',') }}">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-medium text-gray-900">{{ $item->name }}</span>
                                    <span class="text-blue-700 font-bold">${{ $item->price }}</span>
                                </div>
                                @if ($item->description)
                                    <p class="text-gray-600 text-sm mt-1">{{ $item->description }}</p>
                                @endif
                                @if($item->allergens->count() > 0)
                                    <div class="mt-2">
                                        <span class="text-xs text-gray-500">Allergens: </span>
                                        @foreach($item->allergens as $allergen)
                                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                                {{ $allergen->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400 italic">There are no items in this category.</p>
                @endif
            </div>
        @endforeach
    </div>

    @if($showAllergenFilter)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allergenFilters = document.querySelectorAll('.allergen-filter');
            const menuItems = document.querySelectorAll('.menu-item');
            const clearFiltersBtn = document.getElementById('clear-filters');

            function filterMenuItems() {
                const excludedAllergens = Array.from(allergenFilters)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                menuItems.forEach(item => {
                    const itemAllergens = item.dataset.allergens.split(',').filter(id => id !== '');
                    const hasExcludedAllergen = excludedAllergens.some(allergenId => 
                        itemAllergens.includes(allergenId)
                    );

                    if (excludedAllergens.length === 0 || !hasExcludedAllergen) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            allergenFilters.forEach(checkbox => {
                checkbox.addEventListener('change', filterMenuItems);
            });

            clearFiltersBtn.addEventListener('click', function() {
                allergenFilters.forEach(checkbox => {
                    checkbox.checked = false;
                });
                filterMenuItems();
            });
        });
    </script>
    @endif
</body>
</html> 