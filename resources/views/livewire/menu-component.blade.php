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
                            <li class="{{ count($child->children) ? 'dropdown' : '' }}">
                                <a href="{{ $child->url ?? '#' }}" class="menu-link" data-url="{{ $child->url }}">{{ $child->name }}</a>
                                @if(count($child->children))
                                    <ul>
                                        @foreach ($child->children as $subchild)
                                            <li><a href="{{ $subchild->url ?? '#' }}" class="menu-link" data-url="{{ $subchild->url }}">{{ $subchild->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>