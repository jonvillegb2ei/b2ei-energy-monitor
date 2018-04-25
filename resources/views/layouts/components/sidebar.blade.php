<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{url('images/logo.svg')}}" class="img-circle" alt="App logo">
            </div>
            <div class="pull-left info">
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
                    <i class="fa fa-home"></i> <span>{{ trans('app.sidebar.dashboard')}}</span>
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'equipments' ? 'active' : ''}}">
                <a href="{{route('equipments')}}">
                    <i class="fa fa-line-chart"></i> <span>{{ trans('app.sidebar.equipments')}}</span>
                </a>
            </li>
            @administrator
            <li class="header">
                {{ trans('app.sidebar.administrator')}}
            </li>
            <li class="{{Route::currentRouteName() == 'users' ? 'active' : ''}}">
                <a href="{{route('users')}}">
                    <i class="fa fa-users"></i> <span>{{ trans('app.sidebar.users')}}</span>
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'technician' ? 'active' : ''}}">
                <a href="{{route('technician')}}">
                    <i class="fa fa-wrench"></i> <span>{{ trans('app.sidebar.technician')}}</span>
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'settings' ? 'active' : ''}}">
                <a href="{{route('settings')}}">
                    <i class="fa fa-gear"></i> <span>{{ trans('app.sidebar.settings')}}</span>
                </a>
            </li>
            @endadministrator
            <li class="header">{{ trans('app.sidebar.account')}}</li>
            <li class="{{Route::currentRouteName() == 'profile' ? 'active' : ''}}">
                <a href="{{route('profile')}}">
                    <i class="fa fa-user"></i> <span>{{ trans('app.sidebar.profile')}}</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> <span>{{ trans('app.sidebar.logout')}}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
</aside>
