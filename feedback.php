<?php require_once __DIR__ . '/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="Share your valuable feedback with North Nazimabad Gymkhana - help us improve our services and facilities.">
    <title>North Nazimabad Gymkhana | Share Your Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/public-refresh.css'), ENT_QUOTES, 'UTF-8'); ?>">
</head>

<body class="page-feedback">
    <div id="loading-page">
        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="North Nazimabad Gymkhana" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        <div class="loading-text">EST. 2007</div>
    </div>

    <div class="main-content">
        <a href="#" class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up-short"></i>
        </a>

        <?php include __DIR__ . '/navbar.php'; ?>

        <div class="feedback-container">
            <div class="feedback-card" data-aos="fade-up">
                <div class="feedback-header">
                    <h1>Share Your Feedback</h1>
                    <p class="description">We value your opinion! Please share your experience with us to help us improve our services.</p>
                    <div class="divider"></div>
                    <h2 class="feedback-subtitle">Tell us what you think</h2>
                </div>

                <div class="success-message" id="successMessage">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Thank you for your feedback!</strong><br>
                    Your submission has been received successfully.
                </div>

                <form id="feedbackForm">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" id="userName" placeholder="Enter your full name">
                        <div class="error-message" id="nameError">Please enter at least 5 characters (letters only)</div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="userEmail" placeholder="Enter your email">
                        <div class="error-message" id="emailError">Please enter a valid email address</div>
                    </div>

                    <div class="form-group">
                        <label>Select Feedback Type</label>
                        <select id="feedbackType">
                            <option value="" selected disabled>Select Feedback Type</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="complaint">Complaint</option>
                            <option value="appreciation">Appreciation</option>
                            <option value="general">General Feedback</option>
                        </select>
                        <div class="error-message" id="typeError">Please select a feedback type</div>
                    </div>

                    <div class="form-group">
                        <label>Your Feedback</label>
                        <textarea id="userMessage" placeholder="Please share your detailed feedback here..."></textarea>
                        <div class="error-message" id="messageError">Please enter at least 10 characters</div>
                    </div>

                    <div class="rating-container">
                        <h3>How do you feel about our services?</h3>
                        <div class="emoji-grid">
                            <div class="emoji-item" data-rating="1">
                                <div class="emoji-circle">🥺</div>
                                <span class="emoji-label">Very Unsatisfied</span>
                            </div>
                            <div class="emoji-item" data-rating="2">
                                <div class="emoji-circle">😕</div>
                                <span class="emoji-label">Unsatisfied</span>
                            </div>
                            <div class="emoji-item" data-rating="3">
                                <div class="emoji-circle">😐</div>
                                <span class="emoji-label">Neutral</span>
                            </div>
                            <div class="emoji-item" data-rating="4">
                                <div class="emoji-circle">🙂</div>
                                <span class="emoji-label">Satisfied</span>
                            </div>
                            <div class="emoji-item" data-rating="5">
                                <div class="emoji-circle">😊</div>
                                <span class="emoji-label">Very Satisfied</span>
                            </div>
                        </div>
                        <div class="error-message" id="emojiError">Please select your satisfaction level</div>

                        <div class="star-container">
                            <div class="stars">
                                <span class="star" data-rating="1">&#9733;</span>
                                <span class="star" data-rating="2">&#9733;</span>
                                <span class="star" data-rating="3">&#9733;</span>
                                <span class="star" data-rating="4">&#9733;</span>
                                <span class="star" data-rating="5">&#9733;</span>
                            </div>
                            <span class="rating-value" id="ratingValue">0/5</span>
                        </div>
                        <div class="rating-labels">
                            <span>Poor</span>
                            <span>Excellent</span>
                        </div>
                        <div class="error-message" id="starError">Please provide an overall rating</div>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        Submit Feedback
                    </button>
                </form>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4" data-aos="fade-right">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Logo" class="footer-logo mb-3">
                        <p>North Nazimabad Gymkhana excellence in sports, fitness, and community since 2007.</p>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <h5>EXPLORE</h5>
                        <div class="footer-links">
                            <a href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>">Home</a>
                            <a href="<?php echo htmlspecialchars(app_url('about'), ENT_QUOTES, 'UTF-8'); ?>">About</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Facilities</a>
                            <a href="<?php echo htmlspecialchars(app_url('feedback'), ENT_QUOTES, 'UTF-8'); ?>">Feedback</a>
                            <a href="<?php echo htmlspecialchars(app_url('membership'), ENT_QUOTES, 'UTF-8'); ?>">Membership</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <h5>FACILITIES</h5>
                        <div class="footer-links">
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Health & Fitness</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Sports Complex</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Swimming Pool</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Indoor Games</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Event Spaces</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-left" data-aos-delay="300">
                        <h5>CONNECT</h5>
                        <p>Subscribe to receive updates on events, tournaments, and membership offers.</p>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email address">
                            <button class="btn" type="button"><i class="bi bi-send-fill"></i></button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="copyright mb-0">&copy; 2026 North Nazimabad Gymkhana Trust. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?php echo htmlspecialchars(asset_url('assets/js/public-refresh.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
</body>

</html>
