<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>North Nazimabad Gymkhana - Premier Sports & Recreation Club</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts - EXQUISITE PAIRING -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS (Animate on Scroll) for picture effects -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   <link rel="icon" type="image/png" href="assets/images/icon.png">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body id="top" class="page-gallery">
    <!-- ===== ENHANCED LOADING PAGE ===== -->
    <div id="loading-page">
        <img src="assets/images/NNG.png" alt="Loading..." class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        <div class="loading-text">LOADING<span class="loading-dots"></span></div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <!-- Back to Top Button -->
        <a href="#top" class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up"></i>
        </a>

        <!-- Navigation -->
        <?php include __DIR__ . '/navbar.php'; ?>

        <!-- Gallery Section -->
        <section class="gallery-section py-5">
            <div class="container">
                <!-- Section Header -->
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-3 style-gallery-001">Our Gallery</h2>
                    <p class="lead mx-auto style-gallery-002">
                        Explore the vibrant life at North Nazimabad Gymkhana through our photo collection
                    </p>
                </div>

                <!-- Gallery Grid -->
                <div class="row g-4">
                    <!-- Image 1 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="50">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image13.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Swimming Pool" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Swimming Pool</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 2 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image14.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Gym Facility" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Modern Gym</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 3 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image23.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Squash Court" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Squash Court</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 4 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image22.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Badminton Court" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Badminton Court</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 5 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image10.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Cricket" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Food Court</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 6 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image34.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Karate" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Karate</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 7 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image15.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Table Tennis" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Indoor Games</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 8 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image36.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Snooker Room" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Snooker Room</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 9 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="450">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image21.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Cricket Ground" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Cricket Ground</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 10 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image19.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Kids Play Area" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Kids Play Area</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 11 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="550">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image35.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Paddel" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Paddel Court</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Image 12 -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                            <img src="assets/images/image1.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Basketball Court" loading="lazy">
                            <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                <h5 class="text-white mb-0">Basket Ball Court</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Images Row -->
                    <div class="row g-4 mt-2">
                        <!-- Image 13 -->
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="650">
                            <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                                <img src="assets/images/image17.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Lawn" loading="lazy">
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                    <h5 class="text-white mb-0">Lawn</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Image 14 -->
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
                            <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                                <img src="assets/images/image20.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="FootBall Ground" loading="lazy">
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                    <h5 class="text-white mb-0">FootBall Ground</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Image 15 -->
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="750">
                            <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-lg">
                                <img src="assets/images/joging.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Jogging Track" loading="lazy">
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-4">
                                    <h5 class="text-white mb-0">Jogging Track</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Events Section -->
      <section id="events-section" class="events-section">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h2>Events</h2>
            <p class="lead">From Sports Tournaments to Community Gatherings<br>Our Event Archive</p>
        </div>

        <div class="row events-grid g-4">
            <!-- Event 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image7.jpg" alt="Badminton Tournament">
                    <div class="event-content">
                        <h4>Badminton Tournament</h4>
                        <p>Players competed with passion and precision, delivering exciting rallies and remarkable performances.</p>
                    </div>
                </div>
            </div>

            <!-- Event 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image1.jpg" alt="Basketball Tournament">
                    <div class="event-content">
                        <h4>BasketBall Tournament</h4>
                        <p>Teams displayed skill, coordination, and determination through intense and competitive matches.</p>
                    </div>
                </div>
            </div>

            <!-- Event 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image37.jpg" alt="Scrabble Tournament">
                    <div class="event-content">
                        <h4>Scrabble Tournament</h4>
                        <p>Participants challenged each other with strategic gameplay, sharp vocabulary, and quick thinking.</p>
                    </div>
                </div>
            </div>

            <!-- Event 4 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image3.jpg" alt="Mehfil-e-Naat">
                    <div class="event-content">
                        <h4>Mehfil-e-Naat</h4>
                        <p>Attendees participated in a soulful gathering, sharing devotion, reverence, and spiritual reflection.</p>
                    </div>
                </div>
            </div>

            <!-- Event 5 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image5.jpg" alt="Flag Hoisting Ceremony">
                    <div class="event-content">
                        <h4>Flag Hoisting Ceremony</h4>
                        <p>Members gathered to hoist the national flag, expressing respect, unity, and love for Pakistan.</p>
                    </div>
                </div>
            </div>

            <!-- Event 6 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image38.jpg" alt="14 August Celebration">
                    <div class="event-content">
                        <h4>14 August Celebration</h4>
                        <p>Enjoy a day full of activities, games, and entertainment for the whole family.</p>
                    </div>
                </div>
            </div>

            <!-- Event 7 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image39.jpg" alt="Red Crescent Society">
                    <div class="event-content">
                        <h4>Red Crescent Society</h4>
                        <p>A Red Crescent first-aid training session was successfully conducted at the gymkhana, enhancing emergency response awareness among our members.</p>
                    </div>
                </div>
            </div>

            <!-- Event 8 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="450">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image41.jpg" alt="New Year Celebration">
                    <div class="event-content">
                        <h4>New Year Celebration</h4>
                        <p>Members enjoyed fireworks, music, and welcoming the new year together.</p>
                    </div>
                </div>
            </div>

            <!-- Event 9 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="event-card animate-on-scroll">
                    <img src="assets/images/image9.jpg" alt="Fun Gala & Hi-Tea">
                    <div class="event-content">
                        <h4>Fun Gala & Hi-Tea</h4>
                        <p>Members and families enjoyed eating together and spending a fun time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Footer - Enhanced -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <!-- Logo and Description -->
                    <div class="col-lg-4 mb-4" data-aos="fade-right">
                        <img src="assets/images/NNG.png" alt="Logo" class="mb-3 style-gallery-003">
                        <p>North Nazimabad Gymkhana — excellence in sports, fitness, and community.</p>
                        <div class="social-icons mt-4">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="bi bi-facebook"></i></a>
                           
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <h5 class="mb-3">Explore</h5>
                        <div class="footer-links">
                            <a href="./">Home</a>
                            <a href="about">About</a>
                            <a href="facilllities">Facilities</a>
                            <a href="feedback">Feedback</a>
                            <a href="membership">Membership</a>
                        </div>
                    </div>
                    
                    <!-- Facilities -->
                    <div class="col-lg-2 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <h5 class="mb-3">Facilities</h5>
                        <div class="footer-links">
                            <a href="facilllities">Health & Fitness</a>
                            <a href="facilllities">Sports Facilities</a>
                            <a href="facilllities">Swimming Pool</a>
                            <a href="facilllities">Indoor Games</a>
                            <a href="facilllities">Events</a>
                        </div>
                    </div>
                    
                    <!-- Subscribe -->
                    <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-left" data-aos-delay="300">
                        <h5 class="mb-3">Connect</h5>
                        <p>Subscribe to get updates on events and offers</p>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-primary" type="button">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <!-- Copyright -->
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0 small opacity-75">&copy; 2026 North Nazimabad Gymkhana. All rights reserved.</p>
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
