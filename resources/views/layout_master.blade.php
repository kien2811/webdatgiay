<html>
<head>
    <meta charset="utf-8">
    <title> @yield('title') </title>
    <meta name="viewport" content="width-device-width, initial-scale=1,shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-4.3.1-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-layou-fontend.css')}}">
</head>
<body>
@include('navbar')
@yield('content')
@include('footer')
</body>
</html>
