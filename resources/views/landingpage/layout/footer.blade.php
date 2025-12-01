   <footer class="main-footer">
            <div class="widget-section p_relative pt_80 pb_100">
                <div class="auto-container">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget logo-widget mr_30">
                                <figure class="footer-logo mb_20"><a href="{{ route('home') }}"><img
                                            src="{{ asset('assets/landing/images/logo-himatif-jgu.png') }}" alt=""></a>
                                </figure>
                                <p>HIMATIF JGU is the official student organization dedicated to developing potential,
                                    building networks, and driving innovation in technology for the Informatics
                                    Engineering students of Jakarta Global University.</p>
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
                            {{-- <li><a href="{{ route('home') }}"><i class="icon-22"></i></a></li> --}}
                            {{-- <li><a href="{{ route('home') }}"><i class="icon-23"></i></a></li> --}}
                            <li><a href="https://www.linkedin.com/company/himpunan-mahasiswa-teknik-informatika-jgu/posts/?feedView=all"><i class="icon-24"></i></a></li>
                            <li>
                                <a href="https://www.instagram.com/himatif.jgu/" style="display:inline-block; transition: transform 0.2s;">
                                    <img src="{{ asset('assets/landing/images/instagram.png') }}" alt="Instagram" style="width:24px; height:24px;">
                                </a>
                            </li>
                            </ul>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const instaLink = document.querySelector('a[href="{{ route('home') }}"] img[alt="Instagram"]');
                                    if (instaLink) {
                                        instaLink.parentElement.addEventListener('mousedown', function() {
                                            instaLink.style.transform = 'scale(0.9)';
                                        });
                                        instaLink.parentElement.addEventListener('mouseup', function() {
                                            instaLink.style.transform = 'scale(1)';
                                        });
                                        instaLink.parentElement.addEventListener('mouseleave', function() {
                                            instaLink.style.transform = 'scale(1)';
                                        });
                                    }
                                });
                            </script>   </div>
                </div>
            </div>
        </footer>
