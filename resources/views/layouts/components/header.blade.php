<header class="main-header">
    <a href="{{route('home')}}" class="logo">
        <span class="logo-mini"><b>{{trans('app.vendor')}}</b></span>
        <span class="logo-lg"><b>{{trans('app.vendor')}}</b>&nbsp;<small>{{trans('app.name')}}</small></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{trans('app.toggle-navigation')}}</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <span class="hidden-xs">{{Auth::user()->fullname}}&nbsp;&nbsp;</span>
                        <i class="fa fa-sign-out"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>