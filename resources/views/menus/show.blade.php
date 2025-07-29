{{-- menus/show.blade.php --}}

<h1>{{ $menu->name }}</h1>
<p>{{ $menu->start_time }} - {{ $menu->end_time }}</p>

@if ($menu->description)
    <p>{{ $menu->description }}</p>
@endif

@foreach ($categories as $category)
    <h2>{{ $category->name }}</h2>

    @if ($category->menuItems->count() > 0)
        <ul>
            @foreach ($category->menuItems as $item)
                <li>
                    <strong>{{ $item->name }}</strong> - {{ $item->price }}₺
                    <p>{{ $item->description }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p>Bu kategoride ürün bulunmamaktadır.</p>
    @endif
@endforeach

<a href="{{ url('/') }}">Ana sayfaya dön</a>
