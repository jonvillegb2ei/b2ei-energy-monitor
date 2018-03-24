<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="text-center">
                <p style="color: white">{{Auth::user()->fullname}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">
                {{ __('NAVIGATION')}}
            </li>
            <li class="{{Route::currentRouteName() == 'home' ? 'active' : ''}}">
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i> {{ __('Dashboard') }}
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'equipments' ? 'active' : ''}}">
                <a href="{{route('equipments')}}">
                    <i class="fa fa-line-chart"></i> {{ __('Equipments') }}
                </a>
            </li>
            @administrator
            <li class="header">
                {{ __('ADMINISTRATOR')}}
            </li>
            <li class="{{Route::currentRouteName() == 'users' ? 'active' : ''}}">
                <a href="{{route('users')}}">
                    <i class="fa fa-users"></i> {{ __('Users') }}
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'technician' ? 'active' : ''}}">
                <a href="{{route('technician')}}">
                    <i class="fa fa-wrench"></i> {{ __('Technician') }}
                </a>
            </li>
            <li class="{{Route::currentRouteName() == 'settings' ? 'active' : ''}}">
                <a href="{{route('settings')}}">
                    <i class="fa fa-gear"></i> {{ __('Settings') }}
                </a>
            </li>
            @endadministrator
            <li class="header">{{ __('YOUR ACCOUNT')}}</li>
            <li class="{{Route::currentRouteName() == 'profile' ? 'active' : ''}}">
                <a href="{{route('profile')}}">
                    <i class="fa fa-user"></i> {{ __('Profile') }}
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
</aside>