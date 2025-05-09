<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", config("app.name"))</title>
    <link href="{{asset("assets/css/bootstrap.css")}}" rel="stylesheet">
    <style>
        .auth-link {
            background-color: #212529;
            color: white;
            padding: 4px 12px;
            border: 1px solid #212529;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-right: 4px;
        }

        .auth-link:hover {
            background-color: #495057;
            border-color: #495057;
            color: white;
        }
    </style>
    @yield("styles")
</head>

<body class="d-flex flex-column h-100 bg-dark">
    @include("partials.header")
    @yield("content")
    @include("partials.footer")

    <script src="{{asset("assets/js/bootstrap.bundle.min.js")}}"></script>
    @yield("scripts")
</body>

</html>