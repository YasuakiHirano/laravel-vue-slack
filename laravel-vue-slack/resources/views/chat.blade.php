<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>laravel vue slack</title>
    </head>
    <body class="h-screen w-screen">
        <div id="app" class="h-screen w-screen">
            <router-view></router-view>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
