<div class="top-container">
    <div>
        <div class="container">
            <div class="row header page-main-header">
                <div class="col-sm-2  col-xs-2   col-md-2">
                    <a class="static-link" href="{{url('/')}}">
                    <!--<img class="card-img-top" src="{{url('/img/'.'main-logo-1x.png')}}">-->
                        <img class="" src="https://placehold.it/99x99">

                    </a>

                </div>
                <div class="col-sm-7  col-xs-7  col-md-8">
                    <h3 class="slogan-h">@lang('messages.main_site_header_title')</h3>
                </div>
                <div class="col-sm-3 col-xs-3  col-md-2 container-lang-login">
                    <div class="login-block">
                        @if(!Auth::check())
                            <a class="btn btn-login" href="{{ url('/login') }}">@lang('messages.enter_button')</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="notifications-area">

    </div>
</div>

@if(Auth::user()!=null)

    <div class="container-fluid menu-nav">
        <div class="container">
            <nav class="navbar navbar-default navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#main-navbar-collapse"><span class="sr-only">Toggle navigation</span><span
                                class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="main-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{url('/surveys')}}" class="{{ (Request::is('surveys') ? 'active' : '') }}"><span> @lang('messages.menu_item_current_surveys') </span><noscript></noscript></a></li>
                        <li><a href="{{url('/rewards')}}" class="{{ (Request::is('rewards') ? 'active' : '') }}"><span> @lang('messages.menu_item_history_of_charges') </span></a>
                        </li>
                        <li><a href="{{url('/profiles')}}" class="{{ (Request::is('profiles') ? 'active' : '') }}"><span>@lang('messages.menu_item_profile')</span><!--<span class="badge hasPoll">12</span>--></a>
                        </li>
                        <li><a href="{{route('messages.index')}}" class="{{ (Request::is('messages') ? 'active' : '') }}"><span>@lang('messages.menu_item_messages')</span><span class="badge">{{Auth::user()->unreadNotifications()->count()}}</span></a></li>
                        <li><a href="{{route('rewards.balance')}}" class="{{ (Request::is('rewards/balance') ? 'active' : '') }}"><span>@lang('messages.menu_item_balance') </span><span class="badge">{{Auth::user()->balance}} ₽</span></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span>{{Auth::user()->name}}</span><span> </span><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('/account')}}"><span>@lang('messages.menu_item_settings')</span>
                                        <noscript></noscript>
                                    </a></li>
                                <li role="separator"></li>
                                <li><a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        @lang('messages.menu_item_exit')
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>



@endif