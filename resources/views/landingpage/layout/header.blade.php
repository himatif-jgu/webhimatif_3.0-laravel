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
{{-- <div class="page_direction">
            <div class="demo-rtl direction_switch"><button class="rtl">RTL</button></div>
            <div class="demo-ltr direction_switch"><button class="ltr">LTR</button></div>
        </div>
        <!-- page-direction end --> --}}


<!--Search Popup-->
<div id="search-popup" class="search-popup">
    <div class="popup-inner">
        <div class="upper-box">
            <figure class="logo-box"><a href="{{ route('home') }}"><img src="assets/landing/images/logo-himatif-jgu.png"
                        alt=""></a></figure>
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
                    <div class="search-btn mr_20"><button class="search-toggler"><i class="icon-1"></i></button></div>
                    <div class="btn-box"><a href="{{ route('login') }}" class="theme-btn btn-one">Login</a></div>
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
                    <div class="search-btn mr_20"><button class="search-toggler"><i class="icon-1"></i></button></div>
                    <div class="btn-box"><a href="{{ route('login') }}" class="theme-btn btn-one">Login</a></div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- main-header end -->
