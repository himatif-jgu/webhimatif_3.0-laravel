<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>Himatif Apps</title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('assets/landing/images/logo-himatif.png') }}" type="image/x-icon">
</head>

<body>



    <!-- Content Section -->
    <main>
        @yield('content')
    </main>

    {{-- <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('home') }}" class="theme-btn btn-one">Back to Homepage</a>
    </div> --}}
    <!-- Footer Section -->
    <script>
        // Custom scripts can go here
    </script>
</body>

</html>
