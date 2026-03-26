<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
<title>Facilities – North Nazimabad Gymkhana</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- AOS (Animate on Scroll) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="icon" type="image/png" href="assets/images/icon.png">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body id="top" class="page-facilllities">
    <!-- ===== ENHANCED LOADING PAGE ===== -->
    <div id="loading-page">
        <img src="assets/images/NNG.png" 
             alt="Loading..." 
             class="loading-logo">
        
        <div class="loading-spinner"></div>
        
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        
        <div class="loading-text">
            LOADING<span class="loading-dots"></span>
        </div>
    </div>
    <!-- ===== END LOADING PAGE ===== -->

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <!-- Back to Top Button -->
        <a href="#top" class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up"></i>
        </a>

        <!-- NAVBAR -->
        <?php include __DIR__ . '/navbar.php'; ?>

        <!-- SERVICES HEADER - SIMPLE STYLE -->
        <section class="facility-header" data-aos="fade-up">
            <div class="container text-center">
                <h1 class="facility-title">Our Facilities</h1>
                <p class="facility-subtitle">
                    Where comfort meets activity and wellness<br>
                    Supporting an active lifestyle for all ages.
                </p>
            </div>
        </section>

        <!-- SERVICES CARDS -->
        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <!-- Health -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="services-card">
                            <img src="assets/images/image14.jpg" alt="Health & Fitness">
                            <div class="icon-box"><i class="bi bi-heart-pulse"></i></div>
                            <div class="p-4 text-center">
                                <h4>Health & Fitness</h4>
                                <p>State-of-the-art gym, yoga & wellness programs.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sports -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
                        <div class="services-card">
                            <img src="assets/images/image11.jpg" alt="Sports Facilities">
                            <div class="icon-box"><i class="bi bi-trophy"></i></div>
                            <div class="p-4 text-center">
                                <h4>Sports Facilities</h4>
                                <p>Cricket, tennis, badminton & football.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Swimming -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="services-card">
                            <img src="assets/images/image13.jpg" alt="Swimming Pool">
                            <div class="icon-box"><i class="bi bi-water"></i></div>
                            <div class="p-4 text-center">
                                <h4>Swimming Pool</h4>
                                <p>Olympic-sized pool with trainers.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Events -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="250">
                        <div class="services-card">
                            <img src="assets/images/image3.jpg" alt="Events">
                            <div class="icon-box"><i class="fa-solid fa-calendar-days"></i></div>
                            <div class="p-4 text-center">
                                <h4>Events</h4>
                                <p>Well-planned events held throughout the year for our members</p>
                            </div>
                        </div>
                    </div>

                    <!-- Food Court -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="services-card">
                            <img src="assets/images/image31.jpg" alt="Food Court">
                            <div class="icon-box"><i class="fa-solid fa-plate-wheat"></i></div>
                            <div class="p-4 text-center">
                                <h4>Food Court</h4>
                                <p>Outdoor dining experiences & social gatherings.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Indoor Games -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="350">
                        <div class="services-card">
                            <img src="assets/images/image15.jpg" alt="Indoor Games">
                            <div class="icon-box"><i class="fa-solid fa-table-tennis-paddle-ball"></i></div>
                            <div class="p-4 text-center">
                                <h4>Indoor Games</h4>
                                <p>Enjoy a variety of indoor games in a comfortable and engaging environment.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lawn -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="services-card">
                            <img src="assets/images/image17.jpg" alt="Lawn">
                            <div class="icon-box"><i class="fa-solid fa-leaf"></i></div>
                            <div class="p-4 text-center">
                                <h4>Lawn</h4>
                                <p>Our spacious, well-maintained lawn offers a serene spot for outdoor gatherings.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lobby -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="450">
                        <div class="services-card">
                            <img src="https://www.dhakarachi.org/wp-content/uploads/2022/06/DSC_6736-1-scaled.jpg" alt="Lobby">
                            <div class="icon-box"><i class="fa-solid fa-couch"></i></div>
                            <div class="p-4 text-center">
                                <h4>Lobby</h4>
                                <p>A stylish and comfortable space designed for relaxation, meetings, and socializing.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Playground -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                        <div class="services-card">
                            <img src="assets/images/image19.jpg" alt="Playground">
                            <div class="icon-box"><i class="fa-solid fa-children"></i></div>
                            <div class="p-4 text-center">
                                <h4>Playground</h4>
                                <p>Fun-filled playground where kids can play, explore, and enjoy endless adventures in a secure environment.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER - CUSTOM COLORS -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <!-- Logo and About -->
                    <div class="col-lg-4 mb-4" data-aos="fade-right">
                        <img src="assets/images/NNG.png" alt="Logo" class="style-facilllities-001">
                        <p class="mt-3">North Nazimabad Gymkhana — excellence in sports, fitness, and community.</p>
                        <div class="social-icons mt-4">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="bi bi-facebook"></i></a>
                           
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-4">
                        <h5>Explore</h5>
                        <div class="footer-links">
                            <a href="./">Home</a><br>
                            <a href="about">Our Story</a><br>
                            <a href="facilllities">Experiences</a><br>
                            <a href="feedback">Stories</a><br>
                            <a href="membership">Membership</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <h5>Experiences</h5>
                        <div class="footer-links">
                            <a href="facilllities">Sports</a><br>
                            <a href="facilllities">Dining</a><br>
                            <a href="facilllities">Events</a><br>
                            <a href="facilllities">Wellness</a><br>
                            <a href="facilllities">Social</a>
                        </div>
                    </div>
                    
                    <!-- Newsletter -->
                    <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-left" data-aos-delay="300">
                        <h5>Connect</h5>
                        <p>Subscribe to get updates on events and offers</p>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-primary" type="button">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Divider -->
                <hr class="my-4">
                
                <!-- Copyright -->
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="copyright mb-0">&copy; 2026 North Nazimabad Gymkhana. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div> <!-- End of .main-content -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- JavaScript -->

    <script src="assets/js/main.js"></script>
</body>
</html>
