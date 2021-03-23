<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/">View site</a>
    </li>

    @foreach ($sidebarMenus as $menu)

        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/posttypes/{{ $menu->id }}/posts">{{ $menu->name }}</a>
        </li>

    @endforeach
</ul>
