test sidebar from component

{{-- @foreach (@json($slot) as $menuItem)
    <li class="rounded hover:bg-gray-200 py-2">
        <a class="nav-link active px-2" aria-current="page" href="/posttypes/{{ $menuItem->id }}/posts">
            {{ $menuItem->name }}
        </a>
    </li>
@endforeach --}}

 @json($slot) 
