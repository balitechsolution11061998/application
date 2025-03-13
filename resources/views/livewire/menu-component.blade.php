<nav id="navmenu" class="navmenu">
    <ul>
        @foreach ($menus as $menu)
            <li class="{{ count($menu->children) ? 'dropdown' : '' }}">
                <a href="{{ $menu->url ?? '#' }}" class="menu-link" data-url="{{ $menu->url }}">
                    <span>{{ $menu->name }}</span>
                    @if(count($menu->children)) <i class="bi bi-chevron-down toggle-dropdown"></i> @endif
                </a>
                @if(count($menu->children))
                    <ul>
                        @foreach ($menu->children as $child)
                            @include('components.menu-item', ['menu' => $child])
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
