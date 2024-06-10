<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('user-name')</title>
    <meta charset="UTF-8">
    {{--    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <link rel="icon" href="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/favicon/favicon.ico">
    <link rel="canonical" href="{{request()->url()}}"/>
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

    {{--    Vue.js--}}
    <script defer="defer" src="/js/chunk-vendors.js?v={{ $data['app-version'] }}"></script>
    <script defer="defer" src="/js/index.js?v={{ $data['app-version'] }}"></script>
    <link href="/css/index.css?v={{ $data['app-version'] }}" rel="stylesheet">

</head>
<body>

<div class="app" id="app">
    <div class="app-content">

        @include('admin.layouts.header')

        @yield('content')

        @include('admin.layouts.footer')

    </div>
</div>
</body>
</html>
