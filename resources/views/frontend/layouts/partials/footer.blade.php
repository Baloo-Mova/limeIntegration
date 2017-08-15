
<div class="row">
<div class="container">
    <div class="col-md-4 col-sm-4 col-xs-6 text-center">
        <div class="page-footer__links-block small">
            <h4 class="page-footer__links-header"></h4>
            <ul class="page-footer__links-list text-left">
                <li class="page-footer__links-list-item">
                    <a class="external-link"  href="{{ route('pages.about.us') }}">О нас</a>
                </li>
                <li class="page-footer__links-list-item">
                    <a class="external-link"  href="{{ route('pages.faq') }}">Faq</a>
                </li>
                <li class="page-footer__links-list-item">
                    <a class="external-link"  href="{{ route('pages.confidentiality') }}">Конфиденциальность</a>
                </li>
                <li class="page-footer__links-list-item">
                    <a class="external-link"  href="{{ route('pages.terms') }}">Пользовательское соглашение</a>
                </li>
                <li class="page-footer__links-list-item">
                    <a  href="{{ route('pages.feedback') }}">Обратная связь</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-3 text-center">
        <ul class="social-list">
            <li><a href="http://vk.com/expertnoemnenie"
                   class="external-link  social-list__item  social-list__item--vk"></a></li>
            <li><a href="#"
                   class="external-link  social-list__item  social-list__item--fb"></a></li>
            <li><a href="#" target="_blank"
                   class="external-link  external-link social-list__item social-list__item--ok"></a>
            </li>
        </ul>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-3 text-center">
        <ul class="flags-list">

            <li>
                <a class="external-link flags-list__item" href="{{ route('site.change.locale', ['locale' => 'uk']) }}">
                    <span class="flag-icon flag-icon-ua"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('site.change.locale', ['locale' => 'ru']) }}" class="external-link flags-list__item ">
                    <span class="flag-icon flag-icon-ru"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('site.change.locale', ['locale' => 'ua']) }}" class="external-link flags-list__item  ">
                    <span class="flag-icon flag-icon-gb"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('site.change.locale', ['locale' => 'ua']) }}" class="external-link flags-list__item  ">
                    <span class="flag-icon flag-icon-de"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('site.change.locale', ['locale' => 'ua']) }}" class="external-link flags-list__item  ">
                    <span class="flag-icon flag-icon-by"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('site.change.locale', ['locale' => 'ua']) }}" class="external-link  flags-list__item  ">
                    <span class="flag-icon flag-icon-kz"></span>
                </a>
            </li>
        </ul>
    </div>
</div>
</div>