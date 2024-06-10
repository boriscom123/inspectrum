<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') - @yield('user-name')</title>
    <meta charset="UTF-8">
    {{--    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <link rel="icon" href="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/favicon/favicon.ico">
    <link rel="canonical" href="{{request()->url()}}"/>
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

    {{--    Open Graph--}}
    <meta property="og:type" content="@yield('og-type')">
    <meta property="og:title" content="@yield('og-title')">
    <meta property="og:description" content="@yield('og-description')">
    <meta property="og:image" content="@yield('og-image')">
    <meta property="og:image:height" content="@yield('og-image-height')">
    <meta property="og:image:width" content="@yield('og-image-width')">
    <meta property="og:url" content="@yield('og-url')">

    {{--    Vue.js--}}
    <script defer="defer" src="/js/chunk-vendors.js?v={{ $data['app-version'] }}"></script>
    <script defer="defer" src="/js/index.js?v={{ $data['app-version'] }}"></script>
    <link href="/css/index.css?v={{ $data['app-version'] }}" rel="stylesheet">

    @if($data['app-env'] === 'prod')
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-MSMJ2JTF');</script>
        <!-- End Google Tag Manager -->
    @endif

</head>
<body>

@if($data['app-env'] === 'prod')
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSMJ2JTF"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
@endif

<div class="app" id="app">
    <div class="app-content">

        @include('layouts.header', ['user' => json_encode($data['user'], JSON_UNESCAPED_UNICODE), 'app_env' => $data['app-env']])

        @yield('content')

        @include('layouts.footer')

    </div>
</div>
</body>
</html>
