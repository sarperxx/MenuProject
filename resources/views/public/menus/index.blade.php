{{-- resources/views/public/menus/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menus</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-8 text-center">All Menus</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($menus as $menu)
                <a href="{{ route('public.menus.show', $menu->slug) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-6 border border-gray-100 hover:border-blue-400">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-xl font-semibold text-blue-700">{{ $menu->name }}</h2>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ $menu->start_time }} - {{ $menu->end_time }}</span>
                    </div>
                    @if ($menu->description)
                        <p class="text-gray-600 text-sm mb-2">{{ $menu->description }}</p>
                    @endif
                    <span class="inline-block text-blue-500 text-xs mt-2">View Details</span>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html> 