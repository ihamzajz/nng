<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>North Nazimabad Gymkhana | Feedback</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts - EXQUISITE PAIRING -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS (Animate on Scroll) for effects -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="icon" type="image/png" href="assets/images/icon.png">
    
    <!-- SweetAlert2 for beautiful alerts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="page-feedback">
    <!-- ===== ENHANCED LOADING PAGE ===== -->
    <div id="loading-page">
        <img src="assets/images/NNG.png" alt="Loading..." class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        <div class="loading-text">LOADING<span class="loading-dots"></span></div>
    </div>
    <!-- ===== END LOADING PAGE ===== -->

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <!-- Back to Top Button -->
        <a href="#" class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up"></i>
        </a>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="./">
                    <img src="assets/images/NNG.png" alt="North Nazimabad Gymkhana">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="facilllities">Facilities</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="feedback">Feedback</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="membership" class="btn btn-primary">Membership</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Feedback Section -->
        <section class="feedback-section">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h2 class="feedback-title" data-aos="fade-down">Share Your Feedback</h2>
                        <p class="feedback-subtitle" data-aos="fade-down" data-aos-delay="100">
                            We value your opinion! Please share your experience with us to help us improve our services.
                        </p>

                        <div class="feedback-form-card" data-aos="fade-up" data-aos-delay="200">
                            <h4 data-aos="fade-right">Tell us what you think</h4>

                            <form id="feedbackForm">
                                <!-- Success Message -->
                                <div class="success-message" id="successMessage">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <strong>Thank you for your feedback!</strong><br> Your submission has been received successfully.
                                </div>

                                <!-- Personal Information -->
                                <div class="row">
                                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="250">
                                        <input type="text" class="form-control" id="userName" placeholder="Your Name" required>
                                        <div class="validation-message" id="nameValidation"></div>
                                    </div>
                                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="250">
                                        <input type="email" class="form-control" id="userEmail" placeholder="Email Address" required>
                                        <div class="validation-message" id="emailValidation">Please enter a valid email address</div>
                                    </div>
                                </div>

                                <div data-aos="fade-up" data-aos-delay="300">
                                    <select class="form-control custom-dropdown" id="feedbackType" required>
                                        <option value="" disabled selected>Select Feedback Type</option>
                                        <option value="suggestion">Suggestion</option>
                                        <option value="complaint">Complaint</option>
                                        <option value="appreciation">Appreciation</option>
                                        <option value="general">General Feedback</option>
                                    </select>
                                </div>

                                <!-- Message Area -->
                                <div data-aos="fade-up" data-aos-delay="350">
                                    <textarea class="form-control" id="userMessage" placeholder="Please share your detailed feedback here..." rows="5" required></textarea>
                                    <div class="validation-message" id="messageValidation">Please enter your feedback (minimum 10 characters)</div>
                                </div>

                                <!-- Rating Row -->
                                <div class="rating-row">
                                    <!-- Emoji Rating -->
                                    <div class="rating-section" data-aos="fade-right" data-aos-delay="400">
                                        <h5 class="rating-title">How do you feel about our services?</h5>
                                        <div class="emoji-rating">
                                            <div class="emoji-option" data-rating="1">
                                                <i>😞</i>
                                                <span>Very Unsatisfied</span>
                                            </div>
                                            <div class="emoji-option" data-rating="2">
                                                <i>😕</i>
                                                <span>Unsatisfied</span>
                                            </div>
                                            <div class="emoji-option" data-rating="3">
                                                <i>😐</i>
                                                <span>Neutral</span>
                                            </div>
                                            <div class="emoji-option" data-rating="4">
                                                <i>🙂</i>
                                                <span>Satisfied</span>
                                            </div>
                                            <div class="emoji-option" data-rating="5">
                                                <i>😊</i>
                                                <span>Very Satisfied</span>
                                            </div>
                                        </div>
                                        <div class="validation-message" id="emojiValidation">Please select your satisfaction level</div>
                                    </div>

                                    <!-- Star Rating -->
                                    <div class="rating-section" data-aos="fade-left" data-aos-delay="400">
                                        <h5 class="rating-title">Overall Rating</h5>
                                        <div class="star-rating">
                                            <div class="stars">
                                                <span class="star" data-rating="1">★</span>
                                                <span class="star" data-rating="2">★</span>
                                                <span class="star" data-rating="3">★</span>
                                                <span class="star" data-rating="4">★</span>
                                                <span class="star" data-rating="5">★</span>
                                            </div>
                                            <div class="rating-value" id="ratingValue">0/5</div>
                                        </div>
                                        <div class="rating-labels">
                                            <span>Poor</span>
                                            <span>Excellent</span>
                                        </div>
                                        <div class="validation-message" id="starValidation">Please provide an overall rating</div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn feedback-btn" id="submitBtn" data-aos="fade-up" data-aos-delay="500">
                                    <i class="bi bi-send me-2"></i> Submit Feedback
                                </button>
                            </form>
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
                        <img src="assets/images/NNG.png" alt="Logo" class="mb-3 style-feedback-001">
                        <p>North Nazimabad Gymkhana — excellence in sports, fitness, and community.</p>
                        <div class="social-icons mt-4">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="bi bi-facebook"></i></a>
                           
                            <a href="#"><i class="bi bi-instagram"></i></a>
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
                        <div class="input-group">
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
    </div> <!-- End of .main-content -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS (Animate on Scroll) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JavaScript -->

    <script src="assets/js/main.js"></script>
</body>

</html>