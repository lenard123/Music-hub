<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="favicon.jpg">
        <link rel="stylesheet" type="text/css" href="css/app.css">
        <title>Music Hub</title>
    </head>
    <body>
        <div id="app">
            <notifications group="all"></notifications>
            <router-view></router-view>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>
