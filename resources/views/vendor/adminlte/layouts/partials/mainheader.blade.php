<!-- Main Header -->
<header class="main-header">

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <li><a href="{{ url('/logout') }}" id="logout"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            {{ trans('adminlte_lang::message.signout') }}
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            <input type="submit" value="logout" style="display: none;">
                        </form>
                    </li>
                @endif

            </ul>
        </div>
    </nav>
</header>
