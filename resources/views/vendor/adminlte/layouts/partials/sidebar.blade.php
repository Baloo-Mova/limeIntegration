<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="padding:0px;">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}
                    </a>
                </div>
            </div>
        @endif

    <!-- Sidebar Menu -->
        {{ (Request::is('admin/payments_types') ? 'active' : (Request::is('admin/payments_types/*')? "active": "")) }}
        <ul class="sidebar-menu">
            <li class="header">&nbsp;</li>
            <li class="treeview {{ (Request::is('admin/surveys') ? 'active' : (Request::is('admin/surveys/*')? "active": "")) }}">
                <a href="#"><i class='fa fa-link'></i> <span>Опросы</span> <i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ (Request::is('admin/surveys') ? 'active' : '') }}">
                        <a href="{{ route('admin.surveys.index') }}"><i class='fa fa-link'></i>
                            <span>Список опросов</span></a>
                    </li>
                    <li class="{{ (Request::is('admin/surveys/statistics')? "active": "") }}">
                        <a href="{{ route('admin.surveys.statistics') }}"><i class='fa fa-link'></i> <span>Статистика опросов</span></a>
                    </li>
                    <li class="{{ (Request::is('admin/processing')? "active": "") }}">
                        <a href="{{ route('admin.surveys.processing.index') }}"><i class='fa fa-link'></i> <span>Обработка анкет</span></a>
                    </li>
                </ul>
            </li>
            <li class="{{ (Request::is('admin/manage') ? 'active' : '') }}">
                <a href="{{ route('admin.manage.index') }}" title="Добавление пользователей к опросу">
                    <i class='fa fa-link'></i> <span>Добавление к опросу</span>
                </a>
            </li>
            @if(\Auth::user()->role_id == 2)
                <li><a href="{{ route('admin.pages.index') }}"><i class='fa fa-link'></i> <span>Страницы</span></a></li>
            @endif
            <li class="{{ (Request::is('admin/messages') ? 'active' : "") }}">
                <a href="{{ route('admin.messages.index') }}">
                    <i class='fa fa-link'></i>
                    <span>Сообщения</span>
                </a>
            </li>

            @if(\Auth::user()->role_id == 2)
                <li class="treeview {{ (Request::is('admin/payments') ? 'active' : (Request::is('admin/payments/*')? "active": "")) }}">
                    <a href="#"><i class='fa fa-money'></i> <span>Финансовая часть</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="{{ (Request::is('admin/payments/payments_types') ? 'active' : (Request::is('admin/payments/payments_types/*')? "active": "")) }}">
                            <a href="{{route('admin.paymentstypes.index')}}"><i class='fa fa-money'></i><span>Способ(вид) оплаты</span></a>
                        </li>
                        <li class="{{ (Request::is('admin/payments/withdraws') ? 'active' : (Request::is('admin/payments/withdrawss/*')? "active": "")) }}">
                            <a href="{{route('admin.withdraws.index', ['column' => 'created_at', 'direction' => 'desc'])}}"><i
                                        class='fa fa-money'></i><span>Задачи вывода средств</span></a></li>

                    </ul>
                </li>
                <li class="{{ (Request::is('admin/settings') ? 'active' : "") }}">
                    <a href="{{route('admin.settings')}}"><i class='fa fa-cogs'></i> <span>Настройки</span></a>
                </li>
            @endif
            <li class="{{ (Request::is('admin/users') ? 'active' : (Request::is('admin/users/*')? "active": "")) }}"><a
                        href="{{route('admin.users.index')}}"><i class='fa fa-user'></i> <span>Пользователи</span></a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
