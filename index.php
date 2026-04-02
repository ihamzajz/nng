<?php require_once __DIR__ . '/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="North Nazimabad Gymkhana - Premier Sports & Recreation Club in Karachi since 1965. World-class facilities, community events, and timeless elegance.">
    <title>North Nazimabad Gymkhana | Premier Sports & Recreation Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/public-refresh.css'), ENT_QUOTES, 'UTF-8'); ?>">
</head>

<body class="page-index">
    <div id="loading-page">
        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="North Nazimabad Gymkhana" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        <div class="loading-text">EST. 1965</div>
    </div>

    <div class="main-content">
        <a href="#" class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up-short"></i>
        </a>

        <?php include __DIR__ . '/navbar.php'; ?>

        <section class="hero-section position-relative">
            <div class="hero-overlay"></div>
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/ENTRANCE.jpg'), ENT_QUOTES, 'UTF-8'); ?>" class="hero-img" alt="Gymkhana Entrance">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/BUILDING VEIW.jpg'), ENT_QUOTES, 'UTF-8'); ?>" class="hero-img" alt="Building View">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/BADMINTON FRONT.jpg'), ENT_QUOTES, 'UTF-8'); ?>" class="hero-img" alt="Badminton Court">
                    </div>
                </div>
            </div>
            <div class="hero-content">
                <div class="hero-subtitle" data-aos="fade-down">Since 1965</div>
                <h1 class="hero-title" data-aos="fade-up" data-aos-duration="1000">Welcome to<br>North Nazimabad Gymkhana</h1>
                <p class="hero-description" data-aos="fade-up" data-aos-delay="100">Where legacy lives through sport, community, and timeless elegance</p>
                <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                    <a href="https://maps.app.goo.gl/m3XSCGDdPQHukLAGA" target="_blank" class="btn-outline-light-custom"><i class="bi bi-geo-alt me-2"></i>Discover</a>
                    <a href="<?php echo htmlspecialchars(app_url('contactus'), ENT_QUOTES, 'UTF-8'); ?>" class="btn-primary-hero">Connect With Us</a>
                </div>
            </div>
        </section>

        <section class="welcome-section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6" data-aos="fade-right">
                        <span class="section-subtitle">Since 1965</span>
                        <h2 class="section-title">A Legacy of<br>Excellence</h2>
                        <p class="welcome-text">For over five decades, North Nazimabad Gymkhana has stood as a beacon of community, sport, and refined leisure. Our halls echo with stories of champions, families, and friendships forged through shared passion.</p>
                        <p class="welcome-text">Today, we continue this legacy with world-class facilities, timeless traditions, and an unwavering commitment to excellence.</p>
                        <p class="signature">&mdash; The Management</p>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/BUILDING VEIW.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Heritage" class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
            </div>
        </section>

        <section class="features-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="section-subtitle">Our Offerings</span>
                    <h2 class="section-title">The Art of Living Well</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none">
                            <div class="feature-card">
                                <div class="feature-icon"><i class="bi bi-trophy-fill"></i></div>
                                <h3>Championship Sports</h3>
                                <p>From squash to swimming, our facilities nurture champions at every level</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-cup-straw"></i></div>
                            <h3>Fine Dining</h3>
                            <p>Exquisite culinary experiences in our heritage dining halls</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="<?php echo htmlspecialchars(app_url('gallery#events-section'), ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none">
                            <div class="feature-card">
                                <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                                <h3>Community Events</h3>
                                <p>Celebrations, gatherings, and memories that last a lifetime</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="gallery-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="section-subtitle">Moments Captured</span>
                    <h2 class="section-title">Our Gallery</h2>
                    <p class="welcome-text mx-auto" style="max-width: 700px;">A glimpse into the vibrant life and timeless moments at Gymkhana</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="gallery-item">
                            <img src="<?php echo htmlspecialchars(asset_url('assets/images/SWIMMING.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Swimming Pool">
                            <div class="gallery-overlay"><h5>Swimming Pool</h5></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="gallery-item">
                            <img src="<?php echo htmlspecialchars(asset_url('assets/images/GYM.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Modern Gym">
                            <div class="gallery-overlay"><h5>Fitness Pavilion</h5></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="gallery-item">
                            <img src="<?php echo htmlspecialchars(asset_url('assets/images/SQUASH.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Squash Court">
                            <div class="gallery-overlay"><h5>Squash Hall</h5></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                        <div class="gallery-item">
                            <img src="<?php echo htmlspecialchars(asset_url('assets/images/BADMINTON.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Badminton">
                            <div class="gallery-overlay"><h5>Badminton Court</h5></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="gallery-item">
                            <img src="<?php echo htmlspecialchars(asset_url('assets/images/CRICKET AREA.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Cricket">
                            <div class="gallery-overlay"><h5>Cricket Ground</h5></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
                        <div class="gallery-item">
                            <img src="<?php echo htmlspecialchars(asset_url('assets/images/KARATE.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Karate">
                            <div class="gallery-overlay"><h5>Karate</h5></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <div class="text-center mb-4" data-aos="fade-up">
                            <span class="section-subtitle">Other Videos</span>
                            <h3 class="section-title" style="font-size: 2rem;">NNG Sports Events</h3>
                        </div>
                        <div class="row g-4 justify-content-center" data-aos="fade-up">
                            <div class="col-md-4">
                                <a href="https://youtu.be/mN3E6Dp_vW0?si=DP5wyazm0j1WpwxZ" target="_blank" class="text-decoration-none">
                                    <div class="video-thumbnail-wrapper">
                                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/badminton tournament.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Badminton Tournament">
                                        <div class="play-button-overlay">&#9654;</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="https://youtu.be/9zkvfyBSdbk?si=oK9Y7cPD-Y6mXx0s" target="_blank" class="text-decoration-none">
                                    <div class="video-thumbnail-wrapper">
                                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/SCRABBLE.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Scrabble Tournament">
                                        <div class="play-button-overlay">&#9654;</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="https://youtu.be/dIL0AZ__3sA?si=-M7z1dMcBVVVI2ZE" target="_blank" class="text-decoration-none">
                                    <div class="video-thumbnail-wrapper">
                                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/BASKETBALL.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Basketball">
                                        <div class="play-button-overlay">&#9654;</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="text-center mt-4" data-aos="fade-up">
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank" class="btn-primary-hero" style="display: inline-block; padding: 0.8rem 2rem;">
                                <i class="bi bi-youtube me-2"></i>Watch More on YouTube
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="<?php echo htmlspecialchars(app_url('gallery'), ENT_QUOTES, 'UTF-8'); ?>" class="btn-primary-hero" style="display: inline-block; padding: 0.8rem 2.5rem;">Explore Full Gallery</a>
                </div>
            </div>
        </section>

        <section class="testimonials-section">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="section-subtitle">Stories</span>
                    <h2 class="section-title">Voices of Our Community</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="testimonial-card">
                            <p class="testimonial-text">"Three generations of my family have found joy here. It's more than a club, it's our second home."</p>
                            <div class="testimonial-author">Ahmed R.</div>
                            <div class="testimonial-role">Member since 1985</div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="testimonial-card">
                            <p class="testimonial-text">"The squash facilities are world-class. I trained here as a junior, now I bring my own children."</p>
                            <div class="testimonial-author">Fatima S.</div>
                            <div class="testimonial-role">National Player</div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="testimonial-card">
                            <p class="testimonial-text">"Every event is impeccable. The staff, the ambiance, the attention to detail simply unmatched."</p>
                            <div class="testimonial-author">Omar K.</div>
                            <div class="testimonial-role">Event Host</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Logo" style="width: 100px; height: auto;" class="mb-3">
                        <p>Since 1965, North Nazimabad Gymkhana has been the heart of community, sport, and refined leisure in Karachi.</p>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <h5>EXPLORE</h5>
                        <div class="footer-links">
                            <a href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>">Home</a>
                            <a href="<?php echo htmlspecialchars(app_url('about'), ENT_QUOTES, 'UTF-8'); ?>">About</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Facilities</a>
                            <a href="<?php echo htmlspecialchars(app_url('feedback'), ENT_QUOTES, 'UTF-8'); ?>">Feedback</a>
                            <a href="<?php echo htmlspecialchars(app_url('membership'), ENT_QUOTES, 'UTF-8'); ?>">Membership</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <h5>EXPERIENCES</h5>
                        <div class="footer-links">
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Sports</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Dining</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Events</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Wellness</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Social</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <h5>CONNECT</h5>
                        <p>Subscribe to our newsletter for events and offers</p>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn" type="button"><i class="bi bi-send-fill"></i></button>
                        </div>
                        <p class="mt-3 small opacity-50">Be the first to know</p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="copyright mb-0">&copy; 2026 North Nazimabad Gymkhana Trust. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?php echo htmlspecialchars(asset_url('assets/js/public-refresh.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</body>

</html>
