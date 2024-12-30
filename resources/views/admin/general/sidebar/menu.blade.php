
@if(checkPermission('admin.menu.view'))
    <li class=" navigation-header "><span>{{ trans('general.menu') }}</span></li>
    <li class=" nav-item 
    {{ Request::segment(2) === 'menu' ? 'open' : null }}

    ">
        <a href="#">
            <i class='bx bxl-product-hunt'></i>
            <span class="menu-title" data-i18n="Content">{{ trans('general.menu') }}</span></a>
        <ul class="menu-content">
            <li><a href="{{ route('admin.menu.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>
                    <span class="menu-item" data-i18n="Typography">{{ trans('general.menu') }}</span>
                </a>
            </li>
            @if(checkPermission('admin.menu.create'))
                <li><a href="{{ route('admin.menu.create') }}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item" data-i18n="Typography">{{ trans('general.add') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
