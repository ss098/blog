<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ url('image/fire-orange.png') }}" />
        <link rel="apple-touch-icon" href="{{ url('image/fire-orange.png') }}" />

        <title>正义的小可爱</title>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ elixir('css/app.css') }}">
    </head>
    <body>
        <div id="app"></div>
        <!--其实我也不想这样引入 Promise 的-->
        <script type="text/javascript" src="/js/promise.min.js"></script>
        <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>
    </body>
</html>
