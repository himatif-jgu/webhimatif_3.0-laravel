<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>Himatif Apps</title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('assets/landing/images/logo-himatif.png') }}" type="image/x-icon">
    @include('layout_landingpage.css')
</head>

<body>
    <!-- Header Section -->

          <header class="main-header header-style-three">
            <div class="header-top">
                <div class="auto-container">
                    <div class="top-inner">
                        <ul class="info">
                            <li><img src="../../assets/images/icons/icon-6.png" alt=""> Call: <a
                                    href="tel:+6282124986343">+62 821-2498-6343</a></li>
                            <li><img src="../../assets/images/icons/icon-7.png" alt=""> Mail: <a
                                    href="mailto:himatif.19@jgu.ac.id">himatif.19@jgu.ac.id</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>



    <!-- Content Section -->
    <main>
        @yield('content')
    </main>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('home') }}" class="theme-btn btn-one">Back to Homepage</a>
    </div>
    <!-- Footer Section -->
    <footer>
        @include('layout_landingpage.footer')
    </footer>
    @include('layout_landingpage.script')
    <script>
        // Custom scripts can go here
    </script>
</body>

</html>
