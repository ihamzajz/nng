<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>North Nazimabad Gymkhana | Modern Elegance</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Google Fonts - EXQUISITE PAIRING -->
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- AOS (Animate on Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/images/icon.png">
    <link rel="stylesheet" href="assets/css/style.css">


</head>


<body id="top" class="page-index">
    <!-- LOADING PAGE - FULLY RESPONSIVE -->
    <div id="loading-page">
        <img src="assets/images/NNG.png" alt="NN Gymkhana" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        <div class="loading-text">Where comfort meets activity and wellness</div>
    </div>

    <div class="main-content">
        <!-- Back to Top -->
        <a href="#top" class="back-to-top" id="backToTop"><i class="bi bi-arrow-up"></i></a>

        <!-- NAVBAR - FULLY RESPONSIVE WITH BOOTSTRAP -->
        <?php include __DIR__ . '/navbar.php'; ?>

        <!-- HERO SECTION - FULLY RESPONSIVE -->
        <section class="hero-section position-relative">
            <div class="hero-overlay"></div>
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/images/image32.jpg" class="hero-img" alt="Gymkhana View">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/image16.jpg" class="hero-img" alt="Indoor Sports">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/image13.jpg" class="hero-img" alt="Swimming Pool">
                    </div>
                </div>
            </div>
            <div class="hero-content">
                <div class="hero-subtitle" data-aos="fade-down">Established 1965</div>
                <h1 class="hero-title" data-aos="fade-up" data-aos-duration="1000">Welcome to<br>North Nazimabad
                    Gymkhana</h1>
                <p class="hero-description" data-aos="fade-up" data-aos-delay="100">Where legacy lives through sport,
                    community, and timeless elegance</p>
                <div class="hero-buttons" data-aos="fade-up" data-aos-delay="100">
                    <a href="https://maps.app.goo.gl/m3XSCGDdPQHukLAGA" target="_blank" class="btn btn-outline-light"><i
                            class="bi bi-geo-alt me-2"></i>Discover</a>
                    <a href="contactus" class="btn btn-primary">Connect With Us</a>
                </div>
            </div>
        </section>

        <!-- WELCOME SECTION - FULLY RESPONSIVE -->
        <section class="welcome-section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6" data-aos="fade-right">
                        <span class="section-subtitle">Since 1965</span>
                        <h2 class="section-title">A Legacy of<br>Excellence</h2>
                        <div class="divider"></div>
                        <p class="welcome-text">For over five decades, North Nazimabad Gymkhana has stood as a beacon of
                            community, sport, and refined leisure. Our halls echo with stories of champions, families,
                            and friendships forged through shared passion.</p>
                        <p class="welcome-text">Today, we continue this legacy with world-class facilities, timeless
                            traditions, and an unwavering commitment to excellence.</p>
                        <p class="signature">— The Management</p>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <img src="assets/images/image32.jpg" alt="Heritage" class="img-fluid rounded-4">
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES SECTION - FULLY RESPONSIVE -->
        <section class="features-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="section-subtitle">Our Offerings</span>
                    <h2 class="section-title">The Art of Living Well</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <a href="facilllities" class="style-index-001">
                            <div class="feature-card h-100">
                                <div class="feature-icon"><i class="bi bi-trophy"></i></div>
                                <h3>Championship Sports</h3>
                                <p>From squash to swimming, our facilities nurture champions at every level</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-card h-100">
                            <div class="feature-icon"><i class="bi bi-cup-straw"></i></div>
                            <h3>Fine Dining</h3>
                            <p>Exquisite culinary experiences in our heritage dining halls</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="gallery#events-section"
                            class="style-index-002">
                            <div class="feature-card h-100">
                                <div class="feature-icon"><i class="bi bi-people"></i></div>
                                <h3>Community Events</h3>
                                <p>Celebrations, gatherings, and memories that last a lifetime</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- GALLERY SECTION - FULLY RESPONSIVE -->
        <section class="gallery-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="section-subtitle">Moments Captured</span>
                    <h2 class="section-title">Our Gallery</h2>
                    <p class="welcome-text mx-auto style-index-003">A glimpse into the vibrant life and
                        timeless moments at Gymkhana</p>
                </div>
                <div class="row g-4">
                    <!-- Gallery Items -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="gallery-item">
                            <img src="assets/images/image13.jpg" alt="Swimming Pool" class="img-fluid">
                            <div class="gallery-overlay">
                                <div>
                                    <h5>Swimming Pool</h5>
                                    <p>Serenity meets sport in our crystal-clear waters.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="gallery-item">
                            <img src="assets/images/image14.jpg" alt="Modern Gym" class="img-fluid">
                            <div class="gallery-overlay">
                                <div>
                                    <h5>Fitness Pavilion</h5>
                                    <p>Strength in elegance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="gallery-item">
                            <img src="assets/images/image23.jpg" alt="Squash Court" class="img-fluid">
                            <div class="gallery-overlay">
                                <div>
                                    <h5>Squash Hall</h5>
                                    <p>Home of legends</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                        <div class="gallery-item">
                            <img src="assets/images/image22.jpg" alt="Badminton" class="img-fluid">
                            <div class="gallery-overlay">
                                <div>
                                    <h5>Badminton Court</h5>
                                    <p>Grace in motion</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="gallery-item">
                            <img src="assets/images/image21.jpg" alt="Cricket" class="img-fluid">
                            <div class="gallery-overlay">
                                <div>
                                    <h5>Cricket Ground</h5>
                                    <p>Where champions are made and legends play.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
                        <div class="gallery-item">
                            <img src="assets/images/image34.jpg" alt="Karate" class="img-fluid">
                            <div class="gallery-overlay">
                                <div>
                                    <h5>Karate</h5>
                                    <p>Discipline of the body, peace of the mind.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-5">
                    <div class="col-12">
                        <div class="text-center mb-4" data-aos="fade-up">
                            <span class="section-subtitle">Other Videos</span>
                            <h3 class="section-title style-index-004">NNG Sports Events</h3>
                            <p class="welcome-text mx-auto style-index-005">Managed by Farhan Arif</p>
                        </div>


                        <div class="style-index-006"
                            data-aos="fade-up">

                            <!-- Video 1 -->
                            <div class="style-index-007">
                                <a href="https://youtu.be/mN3E6Dp_vW0?si=DP5wyazm0j1WpwxZ" target="_blank" class="style-index-008">
                                    <div class="video-thumbnail-wrapper style-index-009">
                                        <img src="assets/images/image10.jpg"
                                            alt="Cricket Match 1"
                                            class="style-index-010">
                                        <div class="play-button-overlay">▶</div>
                                    </div>
                                   
                                </a>
                            </div>

                            <!-- Video 2 -->
                            <div class="style-index-011">
                                <a href="https://youtu.be/9zkvfyBSdbk?si=oK9Y7cPD-Y6mXx0s" target="_blank"
                                    class="style-index-012">
                                    <div class="video-thumbnail-wrapper style-index-013">
                                        <img src="assets/images/image1.jpg"
                                            alt="Cricket Match 2"
                                            class="style-index-014">
                                        <div class="play-button-overlay">▶</div>
                                    </div>
                                </a>
                            </div>

                            <!-- Video 3 -->
                            <div class="style-index-015">
                                <a href="https://youtu.be/dIL0AZ__3sA?si=-M7z1dMcBVVVI2ZE" target="_blank"
                                    class="style-index-016">
                                    <div class="video-thumbnail-wrapper style-index-017">
                                        <img src="assets/images/image15.jpg"
                                            alt="Cricket Match 3"
                                            class="style-index-018">
                                        <div class="play-button-overlay">▶</div>
                                    </div>
                                   
                                </a>
                            </div>

                        </div>

                        <!-- View All Button -->
                        <div class="text-center mt-4" data-aos="fade-up">
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank"
                                class="btn btn-primary px-4 py-2">
                                <i class="bi bi-youtube me-2"></i>Watch More on YouTube
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gallery Button -->
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="gallery" class="btn btn-primary btn-lg px-5 py-3">Explore Full Gallery</a>
                </div>
            </div>
        </section>


        <!-- TESTIMONIALS SECTION - FULLY RESPONSIVE -->
        <section class="testimonials-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="section-subtitle">Stories</span>
                    <h2 class="section-title">Voices of Our Community</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="testimonial-card h-100">
                            <p class="testimonial-text">"Three generations of my family have found joy here. It's more
                                than a club—it's our second home."</p>
                            <div class="testimonial-author">- Ahmed R.</div>
                            <div class="testimonial-role">Member since 1985</div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="testimonial-card h-100">
                            <p class="testimonial-text">"The squash facilities are world-class. I trained here as a
                                junior, now I bring my own children."</p>
                            <div class="testimonial-author">- Fatima S.</div>
                            <div class="testimonial-role">National Player</div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="testimonial-card h-100">
                            <p class="testimonial-text">"Every event is impeccable. The staff, the ambiance, the
                                attention to detail—simply unmatched."</p>
                            <div class="testimonial-author">- Omar K.</div>
                            <div class="testimonial-role">Event Host</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- FOOTER - FULLY RESPONSIVE -->
        <footer class="footer">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <img src="assets/images/NNG.png" alt="Logo" class="img-fluid mb-3 style-index-019">
                        <p>Since 1965, North Nazimabad Gymkhana has been the heart of community, sport, and refined
                            leisure in Karachi.</p>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i
                                    class="bi bi-facebook"></i></a>
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="bi bi-instagram"></i></a>

                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank"><i
                                    class="bi bi-youtube"></i></a>
                        </div>
                    </div>
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
                    <div class="col-lg-4 col-md-4">
                        <h5>Connect</h5>
                        <p>Subscribe to our newsletter for events and offers</p>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-primary" type="button">Send</button>
                        </div>
                        <p class="mt-3 small opacity-50">Be the first to know</p>
                    </div>
                </div>
                <hr class="my-4 opacity-25">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="small opacity-75 mb-0">&copy; 2026 North Nazimabad Gymkhana. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


    <script src="assets/js/main.js"></script>
</body>

</html>
