<head>
    <meta charset="utf-8">
    <title>E-Commerce Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="E-Commerce Dashboard" name="description">  
    <meta name="csrf-token" content="{{ csrf_token() }}">      
    <link rel="fav icon" href="{{ asset('public/images/favicon_io/favicon.ico') }}">
    
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('public/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/lineicons/icon-font/lineicons.css') }}" rel="stylesheet" type="text/css">   
    <!-- App Css-->   

    <link href="{{ asset('public/css/dataTables.bootstrap5.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css"> 
    <script src="{{ asset('public/js/jquery-3.5.1.js')}}"></script>
    <script src="{{ asset('public/js/ckeditor/ckeditor.js') }}" ></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('resources/js/custom.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ env('APP_URL') }}">

  </head>