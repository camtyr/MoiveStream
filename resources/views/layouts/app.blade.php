<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", config("app.name"))</title>
    <link href="{{asset("assets/css/bootstrap.css")}}" rel="stylesheet">
    @stack("styles")
</head>

<body class="d-flex flex-column h-100 bg-dark">
    @include("include.header")
    @yield("content")
    @include("include.footer")

    <script src="{{asset("assets/js/bootstrap.bundle.min.js")}}"></script>
</body>

</html>