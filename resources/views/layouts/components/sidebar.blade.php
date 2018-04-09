<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="text-center">
                <p style="color: white">{{Auth::user()->fullname}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{trans('app.sidebar.online')}}</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">
                {{ trans('app.sidebar.navigation')}}
            </li>
            <li class="{{Route::currentRouteName() == 'home' ? 'active' : ''}}">
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i> {{ trans('app.sidebar.dashboard')}}
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'equipments' ? 'active' : ''}}">
                <a href="{{route('equipments')}}">
                    <i class="fa fa-line-chart"></i> {{ trans('app.sidebar.equipments')}}
                </a>
            </li>
            @administrator
            <li class="header">
                {{ trans('app.sidebar.administrator')}}
            </li>
            <li class="{{Route::currentRouteName() == 'users' ? 'active' : ''}}">
                <a href="{{route('users')}}">
                    <i class="fa fa-users"></i> {{ trans('app.sidebar.users')}}
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'technician' ? 'active' : ''}}">
                <a href="{{route('technician')}}">
                    <i class="fa fa-wrench"></i> {{ trans('app.sidebar.technician')}}
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'settings' ? 'active' : ''}}">
                <a href="{{route('settings')}}">
                    <i class="fa fa-gear"></i> {{ trans('app.sidebar.settings')}}
                </a>
            </li>
            @endadministrator
            <li class="header">{{ trans('app.sidebar.account')}}</li>
            <li class="{{Route::currentRouteName() == 'profile' ? 'active' : ''}}">
                <a href="{{route('profile')}}">
                    <i class="fa fa-user"></i> {{ trans('app.sidebar.profile')}}
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> {{ trans('app.sidebar.logout')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
</aside>
