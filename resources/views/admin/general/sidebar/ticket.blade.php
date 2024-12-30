
<li class=" navigation-header "><span>{{ trans('general.ticket') }}</span></li>
<li class=" nav-item {{ isNavActive('admin.ticket') ? 'open' : null }}">
    <a href="#">
        <i class='bx bxs-purchase-tag-alt' ></i>
        <span class="menu-title" data-i18n="Content">{{ trans('general.ticket') }}</span></a>
    <ul class="menu-content">
        <li class="{{ isNavActive('admin.ticket.index') ? 'active' : null }}"><a href="{{ route('admin.ticket.index') }}">
                <i class="bx bx-right-arrow-alt"></i>
                <span class="menu-item" data-i18n="Typography">{{ trans('general.ticket') }}</span>
            </a>
        </li>
        <li class="{{ isNavActive('admin.ticket.create') || isNavActive('admin.ticket.edit') ? 'active' : null }}"><a href="{{ route('admin.ticket.create') }}">
                <i class="bx bx-right-arrow-alt"></i>
                <span class="menu-item" data-i18n="Typography">{{ trans('general.add') }}</span>
            </a>
        </li>
    </ul>
</li>
