<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", config("app.name"))</title>
    <link href="{{asset("assets/css/bootstrap.css")}}" rel="stylesheet">
</head>

<body>
    @yield("content")

    <script src="{{asset("assets/js/bootstrap.bundle.min.js")}}"></script>
</body>

</html>