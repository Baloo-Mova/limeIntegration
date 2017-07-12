<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        {{ (Request::is('admin/payments_types') ? 'active' : (Request::is('admin/payments_types/*')? "active": "no")) }}
        <ul class="sidebar-menu">

            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class=""><a href="{{ url('home') }}"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
            <li><a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.anotherlink') }}</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.multilevel') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                </ul>
            </li>
            <li class="treeview {{ (Request::is('admin/payments') ? 'active' : (Request::is('admin/payments/*')? "active": "")) }}">
                <a href="#"><i class='fa fa-money'></i> <span>Финансовая часть</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ (Request::is('admin/payments/payments_types') ? 'active' : (Request::is('admin/payments/payments_types/*')? "active": "")) }}"><a href="{{route('admin.paymentstypes.index')}}"><i class='fa fa-money'></i><span>Способ(вид) оплаты</span></a></li>
                    <li class="{{ (Request::is('admin/payments/withdraws') ? 'active' : (Request::is('admin/payments/withdrawss/*')? "active": "")) }}"><a href="{{route('admin.withdraws.index')}}"><i class='fa fa-money'></i><span>Задачи вывода средств</span></a></li>

                </ul>
            </li>
            <li class="{{ (Request::is('admin/users') ? 'active' : (Request::is('admin/users/*')? "active": "")) }}"><a href="{{route('admin.users.index')}}"><i class='fa fa-user'></i> <span>Пользователи</span></a></li>
           </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
