<header class="site-header">
    <div class="header-fixed">
        <div class="site-header-top">
            <div class="container">
                <div class="container-content">
                    <div class="header-block-logo">
                        <a class="logo transition" href="/">
                            <img src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/logo/logo.svg"
                                 alt="logo.svg">
                        </a>
                        <div class="location">
                            <div class="location-icon icon icon-location-dot-solid"></div>
                            <div class="location-text">Уфа</div>
                        </div>
                    </div>
                    <div class="header-block-contacts">
                        <div class="contact">
                            <div class="title">
                                Дежурный врач
                            </div>
                            <div class="phone">
                                <a href="tel:+73472008184">+7 (347) 200-81-84</a>
                            </div>
                        </div>
                        <div class="contact">
                            <div class="title">
                                Для юридических лиц
                            </div>
                            <div class="phone">
                                <a href="tel:+73472000816">+7 (347) 200-08-16</a>
                            </div>
                        </div>
                    </div>
                    <div class="header-block-additional">
                        <div class="search">
                            <div>
                                <label for="header-search">
                                    <input id="header-search" class="transition" type="text"
                                           placeholder="Искать на сайте...">
                                </label>
                                <img class="transition"
                                     src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/black/magnifying-glass-solid.svg"
                                     alt="magnifying-glass-solid.svg">
                            </div>
                        </div>
                        <div class="visually-impaired">
                            <img
                                src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/white/glasses-solid.svg"
                                alt="glasses-solid.svg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-header-bottom">
            <div class="container">
                <div class="container-content">
                    <div class="header-nav">
                        <a href="/about" class="transition">INSPECTRUM CLINIC</a>
                        <a href="/medical_examination" class="transition">Медосмотры</a>
                        <a href="/oformlenie-medknijki" class="transition">Медкнижки</a>
                        <div class="transition">Цены</div>
                        <div class="transition">Услуги</div>
                        <div class="transition">Крайний Север</div>
                        <div class="transition">Контакты</div>
                    </div>
                    <div class="header-nav-bars icon icon-bars-solid"></div>
                    <a href="tel:+73472008184" class="header-phone transition icon icon-phone-solid"></a>
                    <component-user-auth
                        app_env='{{ $app_env }}'
                        :user='{{ $user }}'
                    ></component-user-auth>
                </div>
            </div>
        </div>
    </div>
</header>
