<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>科技大學校園資訊系統</title>
</head>

<body class="bg-light">
    <div id="app">
        <div class="container">
            <div class="header w-100" v-if="show">
                <a href="/" :title="site.title.text"><img :src="site.title.img" alt=""
                        style="width: 100%;height: 80px;"></a>
            </div>
            <div class="main d-flex" style="height: 568px;" v-if="show">
                <div class="col-md-3">
                    <menus :menus="menus" :total="site.total"></menus>
                </div>
                <div class="col-md-6">
                    <div class="main">
                        <marquee>@{{ site . ads }}</marquee>

                        <router-view :mvims="mvims" name="mvim"></router-view>
                        <router-view></router-view>
                        {{-- <mvims :mvims="mvims"></mvims>
                        <news route="index"></news> --}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="right">
                        <login-btn :auth="auth"></login-btn>
                        {{-- @isset($images)
                @foreach ($images as $image) --}}
                        <images :images="images" title="校園風情"></images>
                        {{-- @endforeach
            @endisset --}}

                    </div>
                </div>
            </div>
            <div class="footer w-100" v-if="show">
                <div class="text-center py-4" style="background-color: rgb(172, 224, 162);">&copy;@{{ site . bottom }}
                </div>
            </div>
        </div>
        <div id="modal"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
    {{-- <script src="https://unpkg.com/vue@next"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
    <script src="{{ asset('./js/app.js') }}"></script>
    @yield('script')
</body>

</html>
