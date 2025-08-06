<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>Himatif JGU</title>

    <!-- Fav Icon -->
    <link rel="icon" href="assets/landing/images/logo-himatif.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Stylesheets -->
    <link href="assets/landing/css/font-awesome-all.css" rel="stylesheet">
    <link href="assets/landing/css/flaticon.css" rel="stylesheet">
    <link href="assets/landing/css/owl.css" rel="stylesheet">
    <link href="assets/landing/css/bootstrap.css" rel="stylesheet">
    <link href="assets/landing/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="assets/landing/css/animate.css" rel="stylesheet">
    <link href="assets/landing/css/nice-select.css" rel="stylesheet">
    <link href="assets/landing/css/odometer.css" rel="stylesheet">
    <link href="assets/landing/css/elpath.css" rel="stylesheet">
    <link href="assets/landing/css/color.css" id="jssDefault" rel="stylesheet">
    <link href="assets/landing/css/rtl.css" rel="stylesheet">
    <link href="assets/landing/css/style.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/header.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/banner.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/clients.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/about.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/funfact.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/chooseus.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/category.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/industries.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/process.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/team.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/news.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/subscribe.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/footer.css" rel="stylesheet">
    <link href="assets/landing/css/responsive.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/faq.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/contact.css" rel="stylesheet">
    <link href="assets/landing/css/module-css/page-title.css" rel="stylesheet">

</head>


<!-- page wrapper -->

<body>

    <div class="boxed_wrapper ltr">


        <!-- preloader -->
        <div class="loader-wrap">
            <div class="preloader">
                <div class="preloader-close"><i class="icon-27"></i></div>
                <div id="handle-preloader" class="handle-preloader">
                    <div class="animation-preloader">
                        <div class="spinner"></div>
                        <div class="txt-loading">
                            <span data-text-preloader="H" class="letters-loading">
                                H
                            </span>
                            <span data-text-preloader="I" class="letters-loading">
                                I
                            </span>
                            <span data-text-preloader="M" class="letters-loading">
                                M
                            </span>
                            <span data-text-preloader="A" class="letters-loading">
                                A
                            </span>
                            <span data-text-preloader="T" class="letters-loading">
                                T
                            </span>
                            <span data-text-preloader="I" class="letters-loading">
                                I
                            </span>
                            <span data-text-preloader="H" class="letters-loading">
                                F
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- preloader end -->


        <!-- page-direction -->
        <div class="page_direction">
            <div class="demo-rtl direction_switch"><button class="rtl">RTL</button></div>
            <div class="demo-ltr direction_switch"><button class="ltr">LTR</button></div>
        </div>
        <!-- page-direction end -->


        <!--Search Popup-->
        <div id="search-popup" class="search-popup">
            <div class="popup-inner">
                <div class="upper-box">
                    <figure class="logo-box"><a href="{{ route('home') }}"><img
                                src="assets/landing/images/logo-himatif-jgu.png" alt=""></a></figure>
                    <div class="close-search"><span class="icon-27"></span></div>
                </div>
                <div class="overlay-layer"></div>
                <div class="auto-container">
                    <div class="search-form">
                        <form method="post" action="{{ route('home') }}">
                            <div class="form-group">
                                <fieldset>
                                    <input type="search" class="form-control" name="search-input" value=""
                                        placeholder="Type your keyword and hit" required>
                                    <button type="submit"><i class="icon-1"></i></button>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- main header -->
        <header class="main-header header-style-one">
            <!-- header-lower -->
            <div class="header-lower">
                <div class="auto-container">
                    <div class="outer-box">
                        <figure class="logo-box pl_15"><a href="{{ route('home') }}"><img
                                    src="assets/landing/images/logo-himatif-jgu.png" alt=""></a></figure>
                        <div class="menu-area">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler">
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                            </div>
                            <nav id="navbar" class="main-menu navbar-expand-md navbar-light clearfix">
                                <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    <ul class="navigation">
                                        <li><a href="#home" class="nav-link scrollto active">Home</a></li>
                                        <li><a href="#about" class="nav-link scrollto">About</a></li>
                                        <li><a href="#history" class="nav-link scrollto">History</a></li>
                                        <li><a href="#foundation" class="nav-link scrollto">Foundation</a></li>
                                        <li><a href="#team" class="nav-link scrollto">Team</a></li>
                                        <li><a href="#blog" class="nav-link scrollto">Blog</a></li>
                                        <li><a href="#contact" class="nav-link scrollto">Contact</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="menu-right-content">
                            <div class="search-btn mr_20"><button class="search-toggler"><i
                                        class="icon-1"></i></button></div>
                            {{-- <div class="link-box mr_20"><a href="{{ route('login') }}">Log In</a></div> --}}
                            <div class="btn-box"><a href="{{ route('error.404') }}" class="theme-btn btn-one">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--sticky Header-->
            <div class="sticky-header">
                <div class="auto-container">
                    <div class="outer-box">
                        <figure class="logo-box pl_15"><a href="{{ route('home') }}"><img
                                    src="assets/landing/images/logo-himatif-jgu.png" alt=""></a></figure>
                        <div class="menu-area">
                            <nav class="main-menu clearfix">
                                <!--Keep This Empty / Menu will come through Javascript-->
                            </nav>
                        </div>
                        <div class="menu-right-content">
                            <div class="search-btn mr_20"><button class="search-toggler"><i
                                        class="icon-1"></i></button></div>
                            {{-- <div class="link-box mr_20"><a href="{{ route('login') }}">Log In</a></div> --}}
                            <div class="btn-box"><a href="{{ route('error.404') }}" class="theme-btn btn-one">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- main-header end -->


        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><i class="fas fa-times"></i></div>
            <nav class="menu-box">
                <div class="nav-logo"><a href="{{ route('home') }}"><img src="assets/landing/images/logo-himatif-jgu.png"
                            alt="" title=""></a></div>
                <div class="menu-outer">
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                <div class="contact-info">
                    <h4>Contact Info</h4>
                    <ul>
                        <li> Jl. Boulevard Grand Depok City, Tirtajaya, Kec. Sukmajaya, Kota Depok, Jawa Barat 16412
                        </li>
                        <li><a href="tel:+6282124986343">+62 821-2498-6343</a></li>
                        <li><a href="mailto:himatif.19@jgu.ac.id">himatif.19@jgu.ac.id</a></li>
                    </ul>
                </div>
                <div class="social-links">
                    <ul class="clearfix">
                        <li><a href="{{ route('home') }}"><span class="fab fa-twitter"></span></a></li>
                        <li><a href="{{ route('home') }}"><span class="fab fa-facebook-square"></span></a></li>
                        <li><a href="{{ route('home') }}"><span class="fab fa-pinterest-p"></span></a></li>
                        <li><a href="{{ route('home') }}"><span class="fab fa-instagram"></span></a></li>
                        <li><a href="{{ route('home') }}"><span class="fab fa-youtube"></span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End Mobile Menu -->


        <!-- home-section -->
        <section id="home" class="banner-section p_relative centred">
            <div class="pattern-layer" style="background-image: url(assets/landing/images/shape/shape-1.png);"></div>
            <div class="author-box">
                <div class="author author-1"><img src="assets/landing/images/welcome/6.png"
                        alt=""><span>SEKRETARIAT</span></div>
                <div class="author author-2"><img src="assets/landing/images/welcome/2.png"
                        alt=""><span>MEDINFO</span></div>
                <div class="author author-3"><img src="assets/landing/images/welcome/3.png"
                        alt=""><span>DANUS</span></div>
                <div class="author author-4"><img src="assets/landing/images/welcome/4.png"
                        alt=""><span>HUMAS</span></div>
                <div class="author author-5"><img src="assets/landing/images/welcome/5.png"
                        alt=""><span>PSDA</span></div>
                <div class="author author-6"><img src="assets/landing/images/welcome/1.png"
                        alt=""><span>RISTEK</span></div>
            </div>
            <div class="auto-container">
                <div class="content-box">
                    <h2>Himpunan Mahasiswa Teknik Informatika</h2>
                    <h3 style="color: #fff; font-style: italic;">Driving #TechForImpact through Digital Innovation</h3>
                    <p>We are more than a community. We are an ecosystem for shaping digital talents who are ready to
                        innovate, collaborate, and create tech solutions that deliver real-world impact, embodying the
                        spirit of impactful science and technology.</p>
                    <div class="btn-box">
                        <a href="{{ route('home') }}" class="theme-btn btn-one mr_20"><span>Explore Our Programs</span></a>
                        <a href="{{ route('home') }}" class="theme-btn banner-btn">Join Us!</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- home-section end -->


        <!-- dikti-section -->
        <section class="clients-section">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="clients-box">

                        <figure class="clients-logo"><a href="https://kemdiktisaintek.go.id/" target="_blank"
                                rel="noopener"><img src="assets/landing/images/resource/tutwuri.png"
                                    alt=""></a></figure>
                        <figure class="overlay-logo"><a href="https://kemdiktisaintek.go.id/" target="_blank"
                                rel="noopener"><img src="assets/landing/images/resource/tutwuri.png"
                                    alt=""></a></figure>
                    </div>
                    <div class="clients-box">
                        <figure class="clients-logo"><a href="https://jgu.ac.id" target="_blank" rel="noopener"><img
                                    src="assets/landing/images/resource/jgu.png" alt=""></a></figure>
                        <figure class="overlay-logo"><a href="https://jgu.ac.id" target="_blank" rel="noopener"><img
                                    src="assets/landing/images/resource/jgu.png" alt=""></a></figure>
                    </div>
                    <div class="clients-box">
                        <figure class="clients-logo"><a href="https://kemdiktisaintek.go.id/" target="_blank"
                                rel="noopener"><img src="assets/landing/images/resource/berdampak.png"
                                    alt=""></a></figure>
                        <figure class="overlay-logo"><a href="https://kemdiktisaintek.go.id/" target="_blank"
                                rel="noopener"><img src="assets/landing/images/resource/berdampak.png"
                                    alt=""></a></figure>
                    </div>
                </div>
            </div>
        </section>
        <!-- dikti-section end -->


        <!-- about-section -->
        <section id="about" class="about-section pt_120 pb_120">
            <div class="auto-container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-sm-12 video-column">
                        <div class="video_block_one">
                            <div class="video-box p_relative pt_40 pb_40 pl_30 centred">
                                <div class="image-layer">
                                    <figure class="image-1"><img src="assets/landing/images/resource/about-us.png"
                                            alt=""></figure>
                                    <figure class="image-2"><img src="assets/landing/images/resource/about-us.png"
                                            alt=""></figure>
                                </div>
                                <div class="video-inner"
                                    style="background-image: url(assets/landing/images/resource/about-us.png);">
                                    <div class="video-content">
                                        <a href="https://www.youtube.com/watch?v=AGbOygxMw88&amp;t=28s"
                                            class="lightbox-image video-btn" data-caption=""><i
                                                class="icon-8"></i><span
                                                class="border-animation border-1"></span><span
                                                class="border-animation border-2"></span><span
                                                class="border-animation border-3"></span></a>
                                        <h6>Watch Video</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="content_block_one">
                            <div class="content-box ml_80">
                                <div class="sec-title pb_20 sec-title-animation animation-style2">
                                    <span class="sub-title mb_10 title-animation">About us</span>
                                    <h2 class="title-animation">Building the Next Generation of
                                        <span>Technologists</span></h2>
                                </div>
                                <div class="text-box">
                                    <p>The Informatics Engineering Student Association (HIMATIF) is the official
                                        organization for all Informatics Engineering students at Jakarta Global
                                        University. We serve as a hub for personal growth, skill development,
                                        professional networking, and creating technology that is both useful and
                                        impactful.</p>
                                    <ul class="list-style-one clearfix">
                                        <li><b>Develop hard skills & soft skills</b> that are directly relevant to the
                                            current needs of the tech industry.</li>
                                        <li><b>Build an extensive network</b> with peers, alumni, faculty, and leading
                                            industry professionals.</li>
                                        <li><b>Gain real-world project and organizational experience</b> that adds
                                            significant value to your portfolio.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-section end -->


        <!-- funfact-section -->
        <section class="funfact-section centred pb_90">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                        <div class="funfact-block-one">
                            <div class="inner-box">
                                <div class="count-outer">
                                    <span class="odometer" data-count="50">000</span><span class="symble">+</span>
                                </div>
                                <p>Active Members</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                        <div class="funfact-block-one">
                            <div class="inner-box">
                                <div class="count-outer">
                                    <span class="odometer" data-count="7">00</span><span class="symble">+</span>
                                </div>
                                <p>Events per Year</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                        <div class="funfact-block-one">
                            <div class="inner-box">
                                <div class="count-outer">
                                    <span class="odometer" data-count="5">00</span><span class="symble">+</span>
                                </div>
                                <p>Partnerships with companies/communities</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 funfact-block">
                        <div class="funfact-block-one">
                            <div class="inner-box">
                                <div class="count-outer">
                                    <span class="odometer" data-count="5">00</span><span class="symble">+</span>
                                </div>
                                <p>Achievements & Awards</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- funfact-section end -->

        <!-- jargon-text -->
        <div class="slide-text">
            <div class="text-inner">
                <ul class="text-list">
                    <li>Who Are We?</li>
                    <li>HIMATIF!</li>
                    <li>One Vision</li>
                    <li>One Mission</li>
                    <li>Ready for Action!</li>
                    <li>Who Are We?</li>
                    <li>HIMATIF!</li>
                    <li>One Vision</li>
                    <li>One Mission</li>
                    <li>Ready for Action!</li>
                    <li>Who Are We?</li>
                    <li>HIMATIF!</li>
                    <li>One Vision</li>
                    <li>One Mission</li>
                    <li>Ready for Action!</li>
                    <li>Who Are We?</li>
                    <li>HIMATIF!</li>
                    <li>One Vision</li>
                    <li>One Mission</li>
                    <li>Ready for Action!</li>
                    <li>Who Are We?</li>
                    <li>HIMATIF!</li>
                    <li>One Vision</li>
                    <li>One Mission</li>
                    <li>Ready for Action!</li>
                    <li>Who Are We?</li>
                    <li>HIMATIF!</li>
                    <li>One Vision</li>
                    <li>One Mission</li>
                    <li>Ready for Action!</li>
                    <li>Who Are We?</li>
                    <li>HIMATIF!</li>
                    <li>One Vision</li>
                    <li>One Mission</li>
                    <li>Ready for Action!</li>
                </ul>
            </div>
        </div>
        <!-- jargon-text end -->

        <!-- chooseus-section -->
        <section class="chooseus-section pt_200 pb_90">
            <div class="pattern-layer" style="background-image: url(assets/landing/images/shape/shape-2.png);"></div>
            <div class="auto-container">
                <div class="sec-title centred pb_60 sec-title-animation animation-style2">
                    <span class="sub-title mb_10 title-animation">Why Us</span>
                    <h2 class="title-animation">Why Join HIMATIF?</h2>
                </div>
                <div class="inner-container">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                            <div class="chooseus-block-one">
                                <div class="inner-box">
                                    <div class="icon-box"><i class="icon-4"></i></div>
                                    <h3><a href="{{ route('home') }}">Develop Professional <br> Skills</a></h3>
                                    <p>Sharpen your abilities through our exclusive workshops, training, and real-world
                                        projects designed to build the most in-demand skills in the tech industry.</p>
                                    <!-- <div class="link"><a href="{{ route('home') }}">Learn More<i class="icon-7"></i></a></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                            <div class="chooseus-block-one">
                                <div class="inner-box">
                                    <div class="icon-box"><i class="icon-5"></i></div>
                                    <h3><a href="{{ route('home') }}">Expand Your Network & Connections</a></h3>
                                    <p>Build valuable connections with peers, successful alumni, and supportive faculty,
                                        plus network with leading professionals from across the entire technology
                                        industry.</p>
                                    <!-- <div class="link"><a href="{{ route('home') }}">Learn More<i class="icon-7"></i></a></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 chooseus-block">
                            <div class="chooseus-block-one">
                                <div class="inner-box">
                                    <div class="icon-box"><i class="icon-6"></i></div>
                                    <h3><a href="{{ route('home') }}">Prepare Your Portfolio & Career</a></h3>
                                    <p>Actively participate in our committees and impactful projects to build a standout
                                        portfolio, giving you a competitive edge for future internships and jobs.</p>
                                    <!-- <div class="link"><a href="{{ route('home') }}">Learn More<i class="icon-7"></i></a></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- chooseus-section end -->

        <!-- dueal-section -->
        <section id="history" class="dueal-section p_relative alternat-2 pt_120 pb_120">
            <div class="bg-color"></div>
            <div class="shape">
                <div class="shape-1"></div>
                <div class="shape-2"></div>
                <div class="shape-3"></div>
                <div class="shape-4"></div>
            </div>
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="content_block_three">
                            <div class="content-box mr_150">
                                <div class="sec-title pb_30 sec-title-animation animation-style2">
                                    <span class="sub-title mb_10 title-animation">Explore Our History</span>
                                    <h2 class="title-animation">Our History in Detail</h2>
                                </div>
                                <ul class="accordion-box">
                                    <li class="accordion block active-block">
                                        <div class="acc-btn active">
                                            <div class="icon-box"><i class="icon-21"></i></div>
                                            <h4>Who were the key figures in our establishment?</h4>
                                        </div>
                                        <div class="acc-content current">
                                            <div class="content">
                                                <p><b>First Daily Executive Board:</b>
                                                    <br>
                                                    Aulia Andhika Pradana (Head of Association) - 2017
                                                    <br>
                                                    Bintang Asrorul Hidayat (Vice Head) - 2017
                                                    <br>
                                                    Dzikril Muttaqin (Secretary) - 2017
                                                    <br>
                                                    Feriyan Rizqi Wijaya (Treasurer) - 2017
                                                    <br>
                                                    <br>
                                                    <b>Grand Deliberation ratified by:</b>
                                                    <br>
                                                    Victor Van Hauten (Presidium I)
                                                    <br>
                                                    Muhammad Qais Abdullah (Presidium II)
                                                    <br>
                                                    Achmad Zaelani Oktarosi (Presidium III)
                                                </p>

                                            </div>
                                        </div>
                                    </li>
                                    <li class="accordion block">
                                        <div class="acc-btn">
                                            <div class="icon-box"><i class="icon-21"></i></div>
                                            <h4>What does the HIMATIF logo symbolize?</h4>
                                        </div>
                                        <div class="acc-content">
                                            <div class="content">
                                                <p> <B>Monitor</B>: Represents the identity of the Informatics
                                                    Engineering program.
                                                    <br>
                                                    <B>Wireless Network</B>: Symbolizes the Networking specialization.
                                                    <br>
                                                    <B>Code Inside Monitor</B>: Symbolizes the Programming
                                                    specialization.
                                                    <br>
                                                    <B>Digital Seven-Segment Numbers</B>: Represent our organization's
                                                    founding date.
                                                    <br>
                                                    <B>Lightning Bolt</B>: Acknowledges our history as part of the
                                                    Electrical Engineering Student Association.
                                                    <br>
                                                    <B></B>HIMATIF & JGU Text</B>: Signifies our identity and home under
                                                    Jakarta Global University.
                                                    <br>
                                                    <B>Two Black Dots</B>: Balances our identity between HIMATIF & the
                                                    JGU Student Executive Board.
                                                    <br>
                                                    <B>Inner & Outer Black Circles</B>: Represent the scope of our
                                                    association within the greater JGU community.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="accordion block">
                                        <div class="acc-btn">
                                            <div class="icon-box"><i class="icon-21"></i></div>
                                            <h4>What is the meaning behind the logo's colors?</h4>
                                        </div>
                                        <div class="acc-content">
                                            <div class="content">
                                                <p><b>Green</b>: Tranquility & Peace.
                                                    <br>
                                                    <B>Black</B>: Firmness & Resolve.
                                                    <br>
                                                    <B>Red</B>: Courage in action and attitude.
                                                    <br>
                                                    <B>White</B>: Sincerity & Purity.
                                                    <br>
                                                    <B>Yellow</B>: Cheerfulness & Joy.
                                                    <br>
                                                    <B>Red & White</B>: Symbolizes the Indonesian flag.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="accordion block">
                                        <div class="acc-btn">
                                            <div class="icon-box"><i class="icon-21"></i></div>
                                            <h4>What was the main goal for founding HIMATIF?</h4>
                                        </div>
                                        <div class="acc-content">
                                            <div class="content">
                                                <p>The primary goal was to create an organization to serve as a hub for
                                                    activities and academic information. This was intended to improve
                                                    the program's accreditation and academic system, as well as
                                                    strengthen relationships between students and faculty through
                                                    practical labs, study groups, and scientific discussions.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="content_block_two">
                            <div class="content-box ml_100">
                                <div class="sec-title light pb_35 sec-title-animation animation-style2">
                                    <span class="sub-title mb_10 title-animation">History of HIMATIF</span>
                                    <h2 class="title-animation">Our Journey</h2>
                                </div>
                                <div class="inner-box">
                                    <div class="single-item">
                                        <span class="count-text">1</span>
                                        <h3><a href="index-2.html">The Foundation (2013-2018)</a></h3>
                                        <p>The journey began when the campus was known as the Jakarta College of
                                            Technology (STTJ). Faced with low accreditation, minimal student activities,
                                            and a need for better resources, Informatics Engineering students agreed to
                                            establish their own association through a series of forums.</p>
                                    </div>
                                    <div class="single-item">
                                        <span class="count-text">2</span>
                                        <h3><a href="index-2.html">Independence (2019)</a></h3>
                                        <p>on May 19, 2019, HIMATIF officially separated from the Electrical Engineering
                                            Student Association (HME). This move was initiated by a Student Deliberation
                                            held on June 27, 2019, laying the groundwork for a new, independent entity.
                                        </p>
                                    </div>
                                    <div class="single-item">
                                        <span class="count-text">3</span>
                                        <h3><a href="index-2.html">Official Establishment (2019)</a></h3>
                                        <p>HIMATIF was officially founded on August 18, 2019, during a Grand
                                            Deliberation at the newly renamed Jakarta Institute of Technology and Health
                                            (ITKJ). This event ratified our official Statutes/Bylaws (AD/ART) and
                                            organizational policies.</p>
                                    </div>
                                    <div class="single-item">
                                        <span class="count-text">4</span>
                                        <h3><a href="index-2.html">The Present Era - Ignis Elevatio Cabinet</a></h3>
                                        <p>Today, under the leadership of the "Ignis Elevatio" cabinet, HIMATIF proudly
                                            operates under the banner of Jakarta Global University (JGU), continuing its
                                            mission to be a central hub for student activities, academic improvement,
                                            and building a strong, innovative community for all Informatics Engineering
                                            students.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- dueal-section end -->

        <!-- category-section -->
        <section id="foundation" class="category-section centred pt_120 pb_70">
            <div class="bg-box">
                <div class="bg-layer parallax-bg" data-parallax='{"y": 100}'
                    style="background-image: url(assets/landing/images/foundation/itsday.png);"></div>
            </div>
            <div class="auto-container">
                <div class="sec-title light pb_60 sec-title-animation animation-style2">
                    <span class="sub-title mb_10 title-animation">OUR FOUNDATION</span>
                    <h2 class="title-animation">HIMATIF JGU's <br>Vision & Mission 2025</h2>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 category-block">
                        <div class="category-block-one">
                            <div class="inner-box">
                                <h2>VISION</h2>
                                <p>Empowering Informatics Engineering students <br>through community and innovation.</p>
                                <a href="{{ route('foundation.vision') }}" class="theme-btn btn-one">See More</a>
                                <figure class="image-box image-hov-one"><img
                                        src="assets/landing/images/foundation/1.png" alt=""></figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 category-block">
                        <div class="category-block-one">
                            <div class="inner-box">
                                <h2>MISSION</h2>
                                <p>Building community, developing skills, and creating opportunities <br>through events,
                                    training, and partnerships.</p>
                                <a href="{{ route('foundation.mission') }}" class="theme-btn btn-one">See More</a>
                                <figure class="image-box image-hov-two"><img
                                        src="assets/landing/images/foundation/2.png" alt=""></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- category-section end -->


        <!-- industries-section -->
        <section id="team" class="industries-section pt_120 pb_70">
            <div class="auto-container">
                <div class="sec-title centred pb_60 sec-title-animation animation-style2">
                    <span class="sub-title mb_10 title-animation">Meet Our Team</span>
                    <h2 class="title-animation">HIMATIF Organizational Structure</h2>
                </div>
                <div class="inner-container clearfix">
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="user" width="40" height="40"></i></div>
                            <h3><a href="#">Head & Vice</a></h3>
                            <p>Core Structure</p>
                        </div>
                    </div>
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="file-text" width="40" height="40"></i>
                            </div>
                            <h3><a href="#">General Secretary</a></h3>
                            <p>Administration & Archives</p>
                        </div>
                    </div>
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="credit-card" width="40" height="40"></i>
                            </div>
                            <h3><a href="#">General Treasurer</a></h3>
                            <p>Financial Management</p>
                        </div>
                    </div>
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="code" width="40" height="40"></i></div>
                            <h3><a href="#">R&D Department</a></h3>
                            <p>Research & Development</p>
                        </div>
                    </div>
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="message-square" width="40"
                                    height="40"></i></div>
                            <h3><a href="#">Media & Info Dept</a></h3>
                            <p>Media & Information</p>
                        </div>
                    </div>
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="users" width="40" height="40"></i></div>
                            <h3><a href="#">Public Relations</a></h3>
                            <p>External Relations</p>
                        </div>
                    </div>
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="award" width="40" height="40"></i></div>
                            <h3><a href="#">HRD Department</a></h3>
                            <p>Human Resources Development</p>
                        </div>
                    </div>
                    <div class="industries-block-one">
                        <div class="inner-box">
                            <div class="icon-box"><i data-feather="shopping-cart" width="40" height="40"></i>
                            </div>
                            <h3><a href="#">Fundraising</a></h3>
                            <p>Funding & Business</p>
                        </div>
                    </div>
                </div>
                {{-- <div class="btn-box centred mt_60"><a href="{{ route('home') }}" class="theme-btn btn-one">View All
                        Categories</a></div> --}}
            </div>
        </section>
        <!-- industries-section end -->


        <!-- team-section -->
        <section class="team-section centred pt_30 pb_70">
            <div class="auto-container">
                <div class="sec-title pb_60 sec-title-animation animation-style2">
                    <span class="sub-title mb_10 title-animation">Our Leadership Structure</span>
                    <h2 class="title-animation">Leadership & Department Heads</h2>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                        <div class="team-block-one wow fadeInUp animated" data-wow-delay="00ms"
                            data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><img src="assets/landing/images/bph/1.png" alt="">
                                    </figure>
                                    <figure class="overlay-image"><img src="assets/landing/images/bph/1.png"
                                            alt=""></figure>
                                </div>
                                <div class="lower-content">
                                    <h3><a href="https://www.linkedin.com/in/YasminHelmy" target="_blank"
                                            rel="noopener">Yasmin Helmy</a></h3>
                                    <span class="designation">President</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                        <div class="team-block-one wow fadeInUp animated" data-wow-delay="200ms"
                            data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><img src="assets/landing/images/bph/2.png" alt="">
                                    </figure>
                                    <figure class="overlay-image"><img src="assets/landing/images/bph/2.png"
                                            alt=""></figure>
                                </div>
                                <div class="lower-content">
                                    <h3><a href="https://www.linkedin.com/in/raihanalfaiz/" target="_blank"
                                            rel="noopener">Muhammad Raihan Alfaiz</a></h3>
                                    <span class="designation">Vice President</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                        <div class="team-block-one wow fadeInUp animated" data-wow-delay="400ms"
                            data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><img src="assets/landing/images/bph/3.png" alt="">
                                    </figure>
                                    <figure class="overlay-image"><img src="assets/landing/images/bph/3.png"
                                            alt=""></figure>
                                </div>
                                <div class="lower-content">
                                    <h3><a href="https://www.linkedin.com/in/ananda-dwi-cynta-0a9014375/"
                                            target="_blank" rel="noopener">Ananda Dwi Cynta</a></h3>
                                    <span class="designation">General Secretary I</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                        <div class="team-block-one wow fadeInUp animated" data-wow-delay="600ms"
                            data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><img src="assets/landing/images/bph/4.png" alt="">
                                    </figure>
                                    <figure class="overlay-image"><img src="assets/landing/images/bph/4.png"
                                            alt=""></figure>
                                </div>
                                <div class="lower-content">
                                    <h3><a href="{{ route('home') }}">Nabilah Rasyiqah</a></h3>
                                    <span class="designation">General Secretary II</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lower-clearfix">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                            <div class="team-block-one wow fadeInUp animated" data-wow-delay="00ms"
                                data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="assets/landing/images/bph/5.png"
                                                alt=""></figure>
                                        <figure class="overlay-image"><img src="assets/landing/images/bph/5.png"
                                                alt=""></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="{{ route('home') }}">Adam Rinaldi</a></h3>
                                        <span class="designation">General Treasurer I</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                            <div class="team-block-one wow fadeInUp animated" data-wow-delay="200ms"
                                data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="assets/landing/images/bph/6.png"
                                                alt=""></figure>
                                        <figure class="overlay-image"><img src="assets/landing/images/bph/6.png"
                                                alt=""></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="{{ route('home') }}">Della Nur Cahya</a></h3>
                                        <span class="designation">General Treasurer II</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                            <div class="team-block-one wow fadeInUp animated" data-wow-delay="400ms"
                                data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="assets/landing/images/bph/7.png"
                                                alt=""></figure>
                                        <figure class="overlay-image"><img src="assets/landing/images/bph/7.png"
                                                alt=""></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="https://www.linkedin.com/in/yosuaimmanuelhk/">Yosua Immanuel</a>
                                        </h3>
                                        <span class="designation">Head of R&D Department</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                            <div class="team-block-one wow fadeInUp animated" data-wow-delay="400ms"
                                data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="assets/landing/images/bph/8.png"
                                                alt=""></figure>
                                        <figure class="overlay-image"><img src="assets/landing/images/bph/8.png"
                                                alt=""></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="https://www.linkedin.com/in/fadli-taptajani/">Muhammad Fadli
                                                Taptajani</a></h3>
                                        <span class="designation">Head of Media & Info Department</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lower-clearfix centred">
                    <div class="row clearfix justify-content-center">
                        <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                            <div class="team-block-one wow fadeInUp animated" data-wow-delay="400ms"
                                data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="assets/landing/images/bph/9.png"
                                                alt=""></figure>
                                        <figure class="overlay-image"><img src="assets/landing/images/bph/9.png"
                                                alt=""></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="{{ route('home') }}">Sarah Ardelia</a></h3>
                                        <span class="designation">Head of Fundraising</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                            <div class="team-block-one wow fadeInUp animated" data-wow-delay="400ms"
                                data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="assets/landing/images/bph/10.png"
                                                alt=""></figure>
                                        <figure class="overlay-image"><img src="assets/landing/images/bph/10.png"
                                                alt=""></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="{{ route('home') }}">Radiva Rizki</a></h3>
                                        <span class="designation">Head of Public Relations</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 team-block">
                            <div class="team-block-one wow fadeInUp animated" data-wow-delay="400ms"
                                data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="assets/landing/images/bph/11.png"
                                                alt=""></figure>
                                        <figure class="overlay-image"><img src="assets/landing/images/bph/11.png"
                                                alt=""></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h3><a href="{{ route('home') }}">Alvando Lefran</a></h3>
                                        <span class="designation">Head of HRD Department</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- team-section end -->

        <!-- process-section -->
        <section class="process-section pt_120 pb_90">
            <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-3.png);"></div>
            <div class="auto-container">
                <div class="sec-title light centred pb_60 sec-title-animation animation-style2">
                    <span class="sub-title mb_10 title-animation">Our Apps</span>
                    <h2 class="title-animation">HIMATIF - Mini Apps</h2>
                </div>
                <div class="tabs-box">
                    <ul class="tab-btns tab-buttons">
                        <li class="tab-btn active-btn" data-tab="#tab-1"><i class="far fa-user"></i>For All</li>
                        <li class="tab-btn" data-tab="#tab-2"><i class="far fa-briefcase"></i>For Member</li>
                    </ul>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="tab-1">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                                    <div class="processing-block-one">
                                        <div class="inner-box">
                                            <span class="count-text">1</span>
                                            <h3><a href="apps/split_bill/{{ route('home') }}">Splitify</a></h3>
                                            <p>Don’t let bills ruin friendships. HIMATIF's smart split-bill feature makes all calculations easy, fast, and transparent for everyone.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                                    <div class="processing-block-one">
                                        <div class="inner-box">
                                            <span class="count-text">2</span>
                                            <h3><a href="{{ route('home') }}">Terminal Goib</a></h3>
                                            <p>Uncover your coding spirit. Our AI terminal assigns you a guardian—be it a legendary khodam, a powerful programming language, or an essential developer tool.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                                    <div class="processing-block-one">
                                        <div class="inner-box">
                                            <span class="count-text">3</span>
                                            <h3><a href="{{ route('home') }}">Spin Wheel</a></h3>
                                            <p>Fair roles, fun results. This interactive wheel is our go-to tool for random draws, perfect for assigning committee roles, presentation orders, or any task that requires an unbiased choice.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab" id="tab-2">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                                    <div class="processing-block-one">
                                        <div class="inner-box">
                                            <span class="count-text">1</span>
                                            <h3><a href="{{ route('home') }}">HIMATIF Connect</a></h3>
                                            <p>Effortless attendance, instant access. Our RFID-based system allows members to check in to events or access facilities with a simple tap of their ID card, making every process seamless.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                                    <div class="processing-block-one">
                                        <div class="inner-box">
                                            <span class="count-text">2</span>
                                            <h3><a href="{{ route('home') }}">Project Hub</a></h3>
                                            <p>Organize, collaborate, and deliver. A centralized platform for managing HIMATIF projects, from task assignments and progress tracking to file sharing, ensuring every team stays on schedule.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                                    <div class="processing-block-one">
                                        <div class="inner-box">
                                            <span class="count-text">3</span>
                                            <h3><a href="{{ route('home') }}">Event Hub</a></h3>
                                            <p>Your central source for all things HIMATIF. This feature provides a complete calendar of upcoming workshops, seminars, and competitions. Members can register for events, access schedules, and download post-event materials all in one place.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- process-section -->


        <!-- news-section -->
        {{-- <section id="blog" class="news-section pt_120 pb_90">
            <div class="auto-container">
                <div class="sec-title centred pb_60 sec-title-animation animation-style2">
                    <span class="sub-title mb_10 title-animation">Media</span>
                    <h2 class="title-animation">Latest News</h2>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                        <div class="news-block-one wow fadeInUp animated" data-wow-delay="00ms"
                            data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="bg-layer"
                                    style="background-image: url(assets/landing/images/news/news-1.jpg);"></div>
                                <div class="overlay-bg-layer"
                                    style="background-image: url(assets/landing/images/news/news-1.jpg);"></div>
                                <div class="content-box">
                                    <span class="post-date">Juli 05, 2025</span>
                                    <h4><a href="blog-details.html">Create a series of blog posts discussing common
                                            interview</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                        <div class="news-block-one wow fadeInUp animated" data-wow-delay="300ms"
                            data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="bg-layer"
                                    style="background-image: url(assets/landing/images/news/news-2.jpg);"></div>
                                <div class="overlay-bg-layer"
                                    style="background-image: url(assets/landing/images/news/news-2.jpg);"></div>
                                <div class="content-box">
                                    <span class="post-date">Juni 19, 2025</span>
                                    <h4><a href="blog-details.html">Explore the concept of personal branding and its
                                            impact on</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                        <div class="news-block-one wow fadeInUp animated" data-wow-delay="600ms"
                            data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="bg-layer"
                                    style="background-image: url(assets/landing/images/news/news-3.jpg);"></div>
                                <div class="overlay-bg-layer"
                                    style="background-image: url(assets/landing/images/news/news-3.jpg);"></div>
                                <div class="content-box">
                                    <span class="post-date">March 18, 2023</span>
                                    <h4><a href="blog-details.html">Feature interviews with employees from top
                                            companies</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-box centred mt_60"><a href="{{ route('home') }}" class="theme-btn btn-one">See More</a>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- news-section end -->

        <section class="page-title centred pt_110">
            <div class="auto-container">
                <div class="content-box">
                    <h1>Contact us</h1>
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>-</li>
                        <li>Contact us</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- subscribe-section -->
        <section id="contact" class="contact-section pt_110 pb_30">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-12 col-sm-12 info-column">
                            <div class="info-box">
                                <h3>Contact Information</h3>
                                <div class="single-item">
                                    <div class="icon-box"><img src="assets/landing/images/icons/icon-27.png"
                                            alt=""></div>
                                    <h4>Jakarta Global University</h4>
                                    <p>Jl. Boulevard Grand Depok City, Tirtajaya, Kec. Sukmajaya, Kota Depok, Jawa Barat
                                        16412</p>
                                </div>
                                <div class="single-item">
                                    <div class="icon-box"><img src="assets/landing/images/icons/icon-28.png"
                                            alt=""></div>
                                    <h4>Email Address</h4>
                                    <p><a href="mailto:support@example.com">himatif.19@jgu.ac.id</a><br /></p>
                                </div>
                                <div class="single-item">
                                    <div class="icon-box"><img src="assets/landing/images/icons/icon-29.png"
                                            alt=""></div>
                                    <h4>Phone Number</h4>
                                    <p><a href="tel:6282124986343">+62 821-2498-6343</a><br /><a
                                            href="tel:628985831080">+62 898-5831-080</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 content-column">
                            <div class="form-inner">
                                <form method="post" action="sendemail.php" id="contact-form">
                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label>Name <span>*</span></label>
                                            <input type="text" name="username" placeholder="" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label>Phone <span>*</span></label>
                                            <input type="text" name="phone" placeholder="" required>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <label>Email Address <span>*</span></label>
                                            <input type="email" name="email" placeholder="" required>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <label>Subject <span>*</span></label>
                                            <input type="text" name="subject" placeholder="" required>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <label>Write Message <span>*</span></label>
                                            <textarea name="message" placeholder=""></textarea>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                            <button type="submit" class="theme-btn btn-one" name="submit-form">Send
                                                Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-section end -->


        <!-- google-map -->
        <section class="google-map pb_80">
            <div class="auto-container">
                <div class="inner-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5433.181097571203!2d106.82631996494015!3d-6.418466203580089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69eb97981e953d%3A0x7040f2673277d58f!2sKampus%20Jakarta%20Global%20University!5e0!3m2!1sen!2sid!4v1753528390371!5m2!1sen!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
        <!-- google-map end -->

        <!-- subscribe-section end -->


        <!-- main-footer -->
        <footer class="main-footer">
            <div class="widget-section p_relative pt_80 pb_100">
                <div class="auto-container">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget logo-widget mr_30">
                                <figure class="footer-logo mb_20"><a href="{{ route('home') }}"><img
                                            src="assets/landing/images/logo-himatif-jgu.png" alt=""></a>
                                </figure>
                                <p>HIMATIF JGU is the official student organization dedicated to developing potential,
                                    building networks, and driving innovation in technology for the Informatics
                                    Engineering students of Jakarta Global University.</p>
                                <!-- <div class="download-btn">
                                    <a href="about.html" class="apple-store">
                                        <img src="assets/landing/images/icons/icon-4.png" alt="">
                                        <span>Download on</span>
                                        App Store
                                    </a>
                                    <a href="about.html" class="play-store">
                                        <img src="assets/landing/images/icons/icon-5.png" alt="">
                                        <span>Get it on</span>
                                        Google Play
                                    </a>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">
                                    <h4>About Us</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        <li><a href="{{ route('home') }}">History</a></li>
                                        <li><a href="{{ route('home') }}">Vision & Mission</a></li>
                                        <li><a href="{{ route('home') }}">Our Structure</a></li>
                                        <li><a href="{{ route('home') }}">The Cabinet</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">
                                    <h4>Activities</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        <li><a href="{{ route('home') }}">Programs</a></li>
                                        <li><a href="{{ route('home') }}">Workshops & Training</a></li>
                                        <li><a href="{{ route('home') }}">Competitions</a></li>
                                        <li><a href="{{ route('home') }}">Event Gallery</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">
                                    <h4>Quick Links</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        <li><a href="about.html">Membership</a></li>
                                        <li><a href="{{ route('home') }}">Blog & Articles</a></li>
                                        <li><a href="{{ route('home') }}">Partnerships</a></li>
                                        <li><a href="blog.html">Latest News</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">
                                    <h4>Support</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        <li><a href="contact.html">Contact Us</a></li>
                                        <li><a href="faq.html">FAQ</a></li>
                                        <li><a href="{{ route('home') }}">Secretariat Location</a></li>
                                        <li><a href="{{ route('home') }}">Privacy Policy</a></li>
                                        <!-- <li><a href="{{ route('home') }}">Terms & Conditions</a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="auto-container">
                    <div class="bottom-inner">
                        <div class="copyright">
                            <p>Copyright &copy; 2024 <a href="{{ route('home') }}">HIMATIF Jakarta Global University</a> All
                                rights reserved.</p>
                        </div>
                        <ul class="social-links">
                            <li>
                                <h5>Follow Us On:</h5>
                            </li>
                            <li><a href="{{ route('home') }}"><i class="icon-22"></i></a></li>
                            <li><a href="{{ route('home') }}"><i class="icon-23"></i></a></li>
                            <li><a href="{{ route('home') }}"><i class="icon-24"></i></a></li>
                            <li><a href="{{ route('home') }}"><i class="icon-25"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- main-footer end -->



        <!--Scroll to top-->
        <div class="scroll-to-top">
            <svg class="scroll-top-inner" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>

    </div>


    <!-- jequery plugins -->
    <script src="assets/landing/js/jquery.js"></script>
    <script src="assets/landing/js/bootstrap.min.js"></script>
    <script src="assets/landing/js/owl.js"></script>
    <script src="assets/landing/js/wow.js"></script>
    <script src="assets/landing/js/validation.js"></script>
    <script src="assets/landing/js/jquery.fancybox.js"></script>
    <script src="assets/landing/js/appear.js"></script>
    <script src="assets/landing/js/isotope.js"></script>
    <script src="assets/landing/js/parallax-scroll.js"></script>
    <script src="assets/landing/js/jquery.nice-select.min.js"></script>
    <script src="assets/landing/js/scrolltop.min.js"></script>
    <script src="assets/landing/js/gsap.js"></script>
    <script src="assets/landing/js/ScrollTrigger.js"></script>
    <script src="assets/landing/js/SplitText.js"></script>
    <script src="assets/landing/js/language.js"></script>
    <script src="assets/landing/js/jquery-ui.js"></script>
    <script src="assets/landing/js/lenis.min.js"></script>
    <script src="assets/landing/js/odometer.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- main-js -->
    <script src="assets/landing/js/script.js"></script>
    <script>
        // Initialize Feather Icons
        feather.replace();

        document.addEventListener("DOMContentLoaded", function() {
            const scrolltoLinks = document.querySelectorAll('.scrollto');

            scrolltoLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah perilaku default dari tautan

                    let targetId = this.getAttribute('href');
                    let targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body><!-- End of .page_wrapper -->

</html>
