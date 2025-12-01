<!DOCTYPE html>
<!--
Template Name: NobleUI - Laravel Admin Dashboard Template
Author: NobleUI
Website: https://nobleui.com
Contact: nobleui.team@gmail.com
Purchase: https://1.envato.market/nobleui_laravel
License: You must have a valid license to legally use the template for your project.
-->
<html>
<head>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive Laravel Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, laravel, theme, front-end, ui kit, web">

  <title>NobleUI - Laravel Admin Dashboard Template</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

  <!-- Base styles -->
  <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet" />

  <!-- Optional dark/light toggle -->
  <script src="{{ asset('assets/admin/js/pages/color-modes.js') }}" defer></script>

  @stack('plugin-styles')
  @stack('style')
</head>
<body data-base-url="{{url('/')}}">

  <script>
    // Create splash screen container
    var splash = document.createElement("div");
    splash.innerHTML = `
      <div class="splash-screen">
        <div class="logo"></div>
        <div class="spinner"></div>
      </div>`;
    
    // Insert splash screen as the first child of the body
    document.body.insertBefore(splash, document.body.firstChild);

    // Add 'loaded' class to body once DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function () {
      document.body.classList.add("loaded");
    });
  </script>

  <div class="main-wrapper" id="app">
    <div class="page-wrapper full-page">
      <div class="page-content container-xxl d-flex align-items-center justify-content-center">
        @yield('content')
      </div>
    </div>
  </div>

    <!-- base js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>window.lucide && window.lucide.createIcons();</script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- common js -->
    @vite(['resources/js/pages/template.js'])
    <!-- end common js -->

    @stack('custom-scripts')
</body>
</html>
