@extends('frontend.layouts.template')

@section('content')



<div class="content-area">
    <div class="container">
        <!-- About us panel -->
            <div class="row">
                
                    <h2>Index</h2>
                
            </div>
            
                <div class="board">
                    <div class="board-header">
                        <div class="board-inner">
                            <ul class="nav nav-tabs" id="myTab">
                                <div class="liner"></div>
                                <li class="active" id="home-li">
                                    <a href="#home" data-toggle="tab" title="Вітаемо">
                                        <span class="round-tabs one">
                                            <i class="glyphicon glyphicon-home"></i>
                                        </span>
                                    </a>
                                </li>
                                <li id="profile-li">
                                    <a href="#profile" data-toggle="tab" title="Ваш профіль">
                                        <span class="round-tabs two">
                                            <i class="glyphicon glyphicon-user"></i>
                                        </span>
                                    </a>
                                </li>
                                <li id="messages-li">
                                    <a href="#messages" data-toggle="tab" title="Додайте свій проект">
                                        <span class="round-tabs three">
                                            <i class="glyphicon glyphicon-list-alt"></i>
                                        </span>
                                    </a>
                                </li>
                                <li id="settings-li">
                                    <a href="#settings" data-toggle="tab" title="Слідкуйте">
                                        <span class="round-tabs four">
                                            <i class="glyphicon glyphicon-comment"></i>
                                        </span>
                                    </a>
                                </li>
                                <li id="doner-li">
                                    <a href="#doner" data-toggle="tab" title="Кінець">
                                        <span class="round-tabs five">
                                            <i class="glyphicon glyphicon-ok"></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="board-content">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="home">
                                <h3 class="head text-center">Вас вітає</h3>
                                <h3 class="text-center">Відкрита регіональна платформа науково-виробничого
                                    партнерства</h3>
                                <h1 class="text-center">
                                    <span style='color: #D30072; font-weight: bold;'>In</span><span
                                        style="color:#00AEEF; font-weight: bold;">Cube</span>
                                </h1>
                                <h4 class="narrow text-center">
                                    Платформа розрахована на реалізацію наукових розробок викладачів і студентів,
                                    актуальних для підприємств Запорізького регіону.
                                </h4>
                                <p class="text-center">
                                    <a href="{{ url('/about') }}" target="_blank"
                                       class="btn btn-success btn-outline-rounded green"> Детальніше
                                        <i class="glyphicon glyphicon-send"></i>
                                    </a>
                                    <a href="#profile" data-toggle="tab"
                                       class="btn btn-success btn-outline-rounded set-active-tab"> Далі
                                        <i class="glyphicon glyphicon-arrow-right"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <h3 class="head text-center">Зареєструйте свій аккаунт</h3>
                                <h4 class="narrow text-center">
                                    Для того, щоб почати роботу - зареєструйтесь
                                </h4>

                                <p class="text-center">
                                    <a href="{{ Auth::check() ? url('/personal-area') : url('/register') }}" target="_blank"
                                       class="btn btn-success btn-outline-rounded green"> Створити свій аккаунт
                                        <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span>
                                    </a>
                                    <a href="#messages" data-toggle="tab"
                                       class="btn btn-success btn-outline-rounded set-active-tab"> Далі
                                        <i class="glyphicon glyphicon-arrow-right"></i>
                                    </a>
                                </p>
                            </div>

                            <div class="tab-pane fade" id="messages">
                                <h3 class="head text-center">Подайте свій проект</h3>
                                <h4 class="narrow text-center">
                                    Розмістіть на платформі свій проект
                                </h4>

                                <p class="text-center">
                                    <a href="{{ url('/designer/create') }}" class="btn btn-success btn-outline-rounded green"> Подати заявку
                                        <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span>
                                    </a>
                                    <a href="#settings" data-toggle="tab"
                                       class="btn btn-success btn-outline-rounded set-active-tab"> Далі
                                        <i class="glyphicon glyphicon-arrow-right"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="settings">
                                <h3 class="head text-center">Слідкуйте за проектом</h3>
                                <h4 class="narrow text-center">
                                    Для подальшого розвитку проекту щодо отримання інвестицій, плану роботи, тощо - радимо спілкуватись з іншими учасниками платформи. 
                                </h4>

                                <p class="text-center">
                                    <a href="#doner" data-toggle="tab"
                                       class="btn btn-success btn-outline-rounded set-active-tab"> Далі
                                        <i class="glyphicon glyphicon-arrow-right"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="doner">
                                <div class="text-center">
                                    <i class="img-intro icon-checkmark-circle"></i>
                                </div>
                                <h3 class="head text-center">Дякуємо</h3>
                                <h4 class="narrow text-center">
                                    Дякуємо за участь у роботі платформи!
                                </h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
      

<!-- end container-->
</div>
<!-- end content area-->
@stop

@section('css')
@stop

@section('js')
<script>
   
</script>

@stop