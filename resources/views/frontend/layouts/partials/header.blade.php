<div class="row header">
    <div class="col-sm-2  col-xs-2   col-md-2">
        <a class="main-logo static-link" href="/"></a>
    </div>
    <div class="col-sm-6  col-xs-6  col-md-7">
        <h1 class="slogan-h">HEADER</h1>
        <h3 class="slogan-h">HEADER</h3>

    </div>
    <div class="col-sm-4 col-xs-4  col-md-3 container-lang-login">
        <div class="login-block">
            @if(!Auth::check())
                <a class="btn btn-success" href="{{ url('/login') }}">Войти</a>
                <a class="btn btn-success" href="{{ url('/register') }}">Регистрация</a>
            @else
                <a href="#" class="btn btn-info">Личный кабинет </a>

                    <a href="{{ url('/logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();" class="btn btn-danger">
                        Выхoд
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

            @endif

        </div>

    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-xs-12 col-md-12">
        <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Navbar</a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('site.index')}}">Опросы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Баланс <span class="badge badge-info">0.00 ₽</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Рейтинг</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Приведи друга</a>
                    </li>
                </ul>
                <form class="form-inline mt-2 mt-md-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
</div>