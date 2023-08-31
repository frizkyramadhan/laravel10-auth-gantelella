<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $title }} - Laravel 10 Auth Gentelella</title>

  <!-- Bootstrap -->
  <link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('assets/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset('assets/build/css/custom.min.css') }}" rel="stylesheet">

  @yield('styles')
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="{{ asset('assets/images/img.jpg') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>{{ auth()->user()->name }}</h2>
            </div>
            <div class="clearfix"></div>
          </div>
          <!-- /menu profile quick info -->

          <br />
