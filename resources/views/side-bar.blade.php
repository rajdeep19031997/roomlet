@foreach ($menus = dashboard_menu()->getAll() as $menu)
    @php $menu = apply_filters(BASE_FILTER_DASHBOARD_MENU, $menu); @endphp
    <li class="nav-item @if ($menu['active']) active @endif" id="{{ $menu['id'] }}">
        <a href="{{ $menu['url'] }}" class="nav-link nav-toggle">
            <i class="{{ $menu['icon'] }}"></i>
            <span class="title">
                {{ !is_array(trans($menu['name'])) ? trans($menu['name']) : null }}
                {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $menu['id']) !!}</span>
            @if (isset($menu['children']) && count($menu['children'])) <span class="arrow @if ($menu['active']) open @endif"></span> @endif
        </a>

        @if (isset($menu['children']) && count($menu['children']))
            <ul class="sub-menu @if (!$menu['active']) hidden-ul @endif">
                @foreach ($menu['children'] as $item)
                    <li class="nav-item @if ($item['active']) active @endif" id="{{ $item['id'] }}">
                        <a href="{{ $item['url'] }}" class="nav-link">
                            <i class="{{ $item['icon'] }}"></i>
                            {{ trans($item['name']) }}
                            {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $item['id']) !!}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach



 <li class="nav-item" id="feedback">
    <a href="{{route('admin.feed')}}" class="nav-link nav-toggle">
        <i class="fas fa-comments"></i>
        <span class="title">Feedback</span>
    </a>
</li>

<li class="nav-item" id="maintenance">
    <a href="{{url('admin/maintenance/list')}}" class="nav-link nav-toggle">
      <i class="fas fa-tools"></i>
        <span class="title">maintenance</span>
    </a>
</li>

<li class="nav-item" id="propertyReport">
    <a href="{{url('/')}}/admin/property-report/list" class="nav-link nav-toggle">
        <i class="fas fa-comments"></i>
        <span class="title">Property Report</span>
    </a>
</li>

<li class="nav-item" id="points_system">
    <a href="{{route('admin.points')}}" class="nav-link nav-toggle">
    <i class="fas fa-coins"></i>
        <span class="title">Points System</span>
    </a>
</li>

<li class="nav-item" id="points_system">
    <a href="{{route('admin.packers')}}" class="nav-link nav-toggle">
    <i class="fas fa-dolly"></i>
        <span class="title">Packers and Movers</span>
    </a>
</li>
<li class="nav-item" id="points_system">
    <a href="{{route('admin.pay-description')}}" class="nav-link nav-toggle">
    <i class="far fa-money-bill-alt"></i>
        <span class="title">Payment Description</span>
    </a>
</li>

<li class="nav-item" id="points_system">
    <a href="{{url('admin/coupon-section/list')}}" class="nav-link nav-toggle">
    <i class="fa fa-tag fa-lg"></i>
        <span class="title">Coupon Code Discount</span>
    </a>
</li>

<li class="nav-item" id="points_system">
    <a href="{{url('admin/offer-section/list')}}" class="nav-link nav-toggle">
    <i class="fa fa-gift" aria-hidden="true"></i>
        <span class="title">Offer Zone</span>
    </a>
</li>