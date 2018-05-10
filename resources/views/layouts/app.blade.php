<!DOCTYPE html>
<!--lang属性规定元素内容的语言 对搜索引擎和浏览器是有帮助 这里是zh-CN -->
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token 方便javascript脚本获取令牌 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BBS') - 论坛系统</title>
    <!--SEO站点描述-->
    <meta name="description" content="@yield('description', 'BBS社区')" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <!--route_class()自定义的辅助方法-->
    <div id="app" class="{{ route_class() }}-page">

        @include('layouts._header')

        <div class="container">
            @include('layouts._message')
            @yield('content')

        </div>

        @include('layouts._footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>