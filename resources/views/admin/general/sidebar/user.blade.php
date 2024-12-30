{{-- @if (auth()->user()->hasAnyPermission(['user:view', 'user:delete', 'user:update', 'user:create']) || auth()->user()->hasRole('super_admin')) --}}
@if(checkPermission('admin.user.view'))
    <li class="navigation-header"><span> {{ trans('general.users') }}</span></li>
    {{-- @can('user:view') --}}
        <li class="nav-item {{ isNavActive('admin.user.index') ? 'active' : '' }}">
            <a href="{{ route('admin.user.index') }}"><i class="bx bx-user"></i><span class="menu-title" data-i18n="Users">
                    {{ trans('general.users') }}</span></a>
        </li>
    {{-- @endcan --}}
    {{-- @can('user:create') --}}
        @if(checkPermission('admin.website-management.create'))

            <li class="nav-item {{ isNavActive('admin.user.create') ? 'active' : '' }}">
                <a href="{{ route('admin.user.create') }}"><i class="bx bx-plus"></i><span class="menu-title" data-i18n="Users">
                        {{ trans('general.add') }}</span></a>
            </li>
        @endif
    {{-- @endcan --}}
@endif
