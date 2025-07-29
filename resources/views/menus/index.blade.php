@foreach ($menus as $menu)
    <div>
        <a href="{{ url('/menus/' . $menu->slug) }}">
            <h2>{{ $menu->name }}</h2>
            <p>{{ $menu->start_time }} - {{ $menu->end_time }}</p>
        </a>
    </div>
@endforeach
