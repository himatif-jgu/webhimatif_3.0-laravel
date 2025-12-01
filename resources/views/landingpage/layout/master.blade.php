<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>Himatif JGU</title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('assets/landing/images/logo-himatif.png') }}" type="image/x-icon">
    @include('landingpage.layout.css')
</head>

<body>
    <!-- Header Section -->
    <header>
        @include('landingpage.layout.header')

    </header>

    <!-- Content Section -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer>
        @include('landingpage.layout.footer')
    </footer>
    @include('landingpage.layout.script')
    <script>
        // Custom scripts can go here
    </script>
</body>

</html>
