@extends('frontend.layouts.template')

@section('content')

    <hr/>

    <div class="static-content-root">
        <div>
            <div class="container-fluid promo">
                <div class="row space">
                    <div class="container">
                        <div class="row-fluid">
                            <div class="col-md-12 text-center">
                                <a class="btn btn-promo-register" href="{{ url('/register') }}">Зарегистрироваться
                                    <p class="big-button-registration">за 10 секунд</p></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid promo-texts">
                <div class="row">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 promo-block">
                                <div class="promo-block__text">
                                    <h2 class="text-red">Заполняйте</h2>
                                    <p class="promo-text promo-text--center">интересные анкеты.</p>
                                    <p class="promo-block__link-container">
                                        <a class="promo-block__link  static-link"
                                           href="https://expertnoemnenie.ru/promo1">Узнать больше →</a>
                                    </p>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4 promo-block">
                                <div class="promo-block__text">
                                    <h2 class="text-red">Влияйте</h2>
                                    <p class="promo-text  promo-text--center">на крупные компании и мир вокруг
                                        вас.</p>
                                    <p class="promo-block__link-container">
                                        <a class="promo-block__link  static-link"
                                           href="#">Узнать больше →</a>
                                    </p>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4 promo-block">
                                <div class="promo-block__text">
                                    <h2 class="text-red">Получайте</h2>
                                    <p class="promo-text  promo-text--center">удовольствие и от 30 до 1000
                                        рублей за опрос.</p>
                                    <p class="promo-block__link-container">
                                        <a class="promo-block__link  static-link"
                                           href="#">Узнать больше →</a>
                                    </p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container container-center">
                    <div class="row">
                        <div class="container">
                            <div class="col-md-12"><p class="logo-header">Ваше мнение будет влиять на:</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container">
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 mobile-box text-center">
                                <img src="{{url('/img/clients/'.'sber.svg')}}" width="170">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 mobile-box text-center">
                                <img src="{{url('/img/clients/'.'ford.png')}}" width="130">
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 mobile-box text-center">
                                <img src="{{url('/img/clients/'.'mail_ru.png')}}" width="170">
                            </div>
                            <div class="clearfix visible-sm-block"></div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 mobile-box text-center">
                                <img src="{{url('/img/clients/'.'kitekat.png')}}" width="130">
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12  mobile-box text-center">
                                <img src="{{url('/img/clients/'.'danone.png')}}" width="130">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 mobile-box text-center">
                                <img src="{{url('/img/clients/'.'pedigree.png')}}" width="130">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
    <script>

    </script>

@stop