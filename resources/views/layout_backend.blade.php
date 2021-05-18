<html>
<head>
    <title> @yield('title') </title>
    <meta name="viewport" content="width-device-width, initial-scale=1,shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('temp_admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('temp_admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('temp_admin/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('temp_admin/dist/css/AdminLTE.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('temp_admin/dist/css/skins/_all-skins.min.css')}}">


</head>
<body>
@include('backend')
<div class="content-wrapper">
@yield('content')
</div>
@include('footer_backend')
</body>
</html>
