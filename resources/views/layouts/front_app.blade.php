<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BSW Movie Club') }}</title>

    <!-- Styles -->
    <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/main-style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
</head>
<body>
    <!--  Header -->
     <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-1 mb-1 navbar-bg">
      <div class="container">
        <div class="row">
           <div class="nav col-md-10 col-9 col-md-auto mb-2 mb-md-0">
              <div class="main-logo">
                   <a href="{{route('home', ['id' => base64_encode(session('city_id'))])}}" class="align-items-center mb-2 mb-md-0 text-dark text-decoration-none"><img src="{{ asset('dist/img/BSW-Movie-Club-Logo.png')}}" alt="BSW Movie Club"></a> 
               </div>
            </div>
            <div class="col-md-2 col-3 text-end">
              <!-- <button type="button" class="btn btn-outline-primary me-2">Login</button>
              <button type="button" class="btn btn-primary">Sign-up</button> -->
              <div class="sub-logo">
              <a href="{{route('home', ['id' => base64_encode(session('city_id'))])}}" class="align-items-center mb-2 mb-md-0 text-dark text-decoration-none"><img src="{{ asset('dist/img/BSW-Socials-Logo.png')}}" alt="BSW Socials"></a> 
              </div>
            </div>
        </div>
      </div>
    </header>

    @yield('front_content')

    <!-- Footer -->
    @include('layouts.front_footer')

</body>
</html>
