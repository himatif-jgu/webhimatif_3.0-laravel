<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
<link href="../assets/landing/css/font-awesome-all.css" rel="stylesheet">
<link href="../assets/landing/css/flaticon.css" rel="stylesheet">
<link href="../assets/landing/css/owl.css" rel="stylesheet">
<link href="../assets/landing/css/bootstrap.css" rel="stylesheet">
<link href="../assets/landing/css/jquery.fancybox.min.css" rel="stylesheet">
<link href="../assets/landing/css/animate.css" rel="stylesheet">
<link href="../assets/landing/css/nice-select.css" rel="stylesheet">
<link href="../assets/landing/css/odometer.css" rel="stylesheet">
<link href="../assets/landing/css/elpath.css" rel="stylesheet">
<link href="../assets/landing/css/color.css" id="jssDefault" rel="stylesheet">
<link href="../assets/landing/css/rtl.css" rel="stylesheet">
<link href="../assets/landing/css/style.css" rel="stylesheet">
<link href="../assets/landing/css/module-css/header.css" rel="stylesheet">
<link href="../assets/landing/css/module-css/error.css" rel="stylesheet">
<link href="../assets/landing/css/module-css/subscribe.css" rel="stylesheet">
<link href="../assets/landing/css/module-css/footer.css" rel="stylesheet">
<link href="../assets/landing/css/responsive.css" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
        </style>
    </head>
    <body>
          <section class="error-section centred pt_200 pb_120">
            <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-25.png);"></div>
            <div class="auto-container">
                <div class="content-box">
                    <h1>@yield('message')</h1>
                    <h3>Page Not Found</h3>
                    <p>This page doesn’t exist or was removed! We suggest you <br />go back to home.</p>
                    <a href="index.html" class="theme-btn btn-one">Back to Homepage</a>
                </div>
            </div>
        </section>
    </body>
</html>

