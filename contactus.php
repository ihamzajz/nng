<?php require_once __DIR__ . '/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="Contact North Nazimabad Gymkhana - Get in touch for membership inquiries, facility information, and event bookings.">
    <title>North Nazimabad Gymkhana | Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/public-refresh.css'), ENT_QUOTES, 'UTF-8'); ?>">
</head>

<body class="page-contactus">
    <div id="loading-page">
        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="North Nazimabad Gymkhana" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        <div class="loading-text">EST. 2007<span class="loading-dots"></span></div>
    </div>

    <div class="main-content">
        <a href="#" class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up-short"></i>
        </a>

        <?php include __DIR__ . '/navbar.php'; ?>

        <section class="contact-hero" data-aos="fade-up">
            <h1>Get In Touch</h1>
            <p>We're here to help you with any questions about our facilities, membership, or events. Reach out to us through any of the channels below.</p>
        </section>

        <div class="contact-container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card animate-on-scroll" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon-wrapper">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h3>Visit Us</h3>
                        <p><strong>North Nazimabad Gymkhana</strong></p>
                        <p>Block H, North Nazimabad</p>
                        <p>Karachi, Pakistan</p>
                        <p><strong>Landmark:</strong> Near Nipa Chowrangi</p>
                        <div class="mt-4">
                            <p><i class="bi bi-clock me-2" style="color: var(--accent-burgundy);"></i> <strong>Open Today:</strong> 6:00 AM - 10:00 PM</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="contact-card animate-on-scroll" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-wrapper">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h3>Call Us</h3>
                        <p>Our team is available during business hours to assist you.</p>
                        <div class="contact-method">
                            <i class="bi bi-phone"></i>
                            <div>
                                <p class="mb-1"><strong>Main Office</strong></p>
                                <p class="mb-0"><a href="tel:+922136678901">+92 21 3667 8901</a></p>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="bi bi-phone-vibrate"></i>
                            <div>
                                <p class="mb-1"><strong>Membership Desk</strong></p>
                                <p class="mb-0"><a href="tel:+922136678902">+92 21 3667 8902</a></p>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="bi bi-whatsapp"></i>
                            <div>
                                <p class="mb-1"><strong>WhatsApp</strong></p>
                                <p class="mb-0"><a href="https://wa.me/923001234567">+92 300 1234567</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="contact-card animate-on-scroll" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-wrapper">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <h3>Email Us</h3>
                        <p>Send us an email and we'll get back to you within 24 hours.</p>
                        <div class="contact-method">
                            <i class="bi bi-envelope-paper"></i>
                            <div>
                                <p class="mb-1"><strong>General Inquiries</strong></p>
                                <p class="mb-0"><a href="mailto:info@nngymkhana.com">info@nngymkhana.com</a></p>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="bi bi-envelope-heart"></i>
                            <div>
                                <p class="mb-1"><strong>Membership</strong></p>
                                <p class="mb-0"><a href="mailto:membership@nngymkhana.com">membership@nngymkhana.com</a></p>
                            </div>
                        </div>
                        <div class="contact-method">
                            <i class="bi bi-calendar-event"></i>
                            <div>
                                <p class="mb-1"><strong>Events & Booking</strong></p>
                                <p class="mb-0"><a href="mailto:events@nngymkhana.com">events@nngymkhana.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="hours-card animate-on-scroll" data-aos="fade-up" data-aos-delay="400">
                        <h3>Business Hours</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="hour-item">
                                    <span class="day">Monday - Friday</span>
                                    <span class="time">6:00 AM - 10:00 PM</span>
                                </div>
                                <div class="hour-item">
                                    <span class="day">Saturday</span>
                                    <span class="time">6:00 AM - 10:00 PM</span>
                                </div>
                                <div class="hour-item">
                                    <span class="day">Sunday</span>
                                    <span class="time">6:00 AM - 10:00 PM</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="hour-item">
                                    <span class="day">Public Holidays</span>
                                    <span class="time">8:00 AM - 8:00 PM</span>
                                </div>
                                <div class="hour-item">
                                    <span class="day">Ramazan Timings</span>
                                    <span class="time">6:00 AM - 4:00 PM</span>
                                </div>
                                <div class="hour-item">
                                    <span class="day">Emergency Contact</span>
                                    <span class="time">24/7 Security: 1122</span>
                                </div>
                            </div>
                        </div>
                        <div class="alert-info mt-4" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Note:</strong> Some facilities may have specific timings. Please check with individual departments for detailed schedules.
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="contact-card animate-on-scroll" data-aos="fade-up" data-aos-delay="500">
                        <h3 class="text-center" style="margin-bottom: 2rem;">Additional Information</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-icon-card">
                                    <i class="fa-solid fa-square-parking"></i>
                                    <h5>Parking Facilities</h5>
                                    <p>Ample parking space available for members and visitors</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-icon-card">
                                    <i class="bi bi-shield-check"></i>
                                    <h5>Security</h5>
                                    <p>24/7 security surveillance and trained security personnel</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-icon-card">
                                    <i class="bi bi-person-wheelchair"></i>
                                    <h5>Accessibility</h5>
                                    <p>Wheelchair accessible facilities throughout the premises</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4" data-aos="fade-right">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Logo" class="footer-logo mb-3">
                        <p style="font-size: 0.9rem; opacity: 0.8;">North Nazimabad Gymkhana excellence in sports, fitness, and community.</p>
                        <div class="social-icons mt-3">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <h5>EXPLORE</h5>
                        <div class="footer-links d-flex flex-column">
                            <a href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>">Home</a>
                            <a href="<?php echo htmlspecialchars(app_url('about'), ENT_QUOTES, 'UTF-8'); ?>">About</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Facilities</a>
                            <a href="<?php echo htmlspecialchars(app_url('feedback'), ENT_QUOTES, 'UTF-8'); ?>">Feedback</a>
                            <a href="<?php echo htmlspecialchars(app_url('membership'), ENT_QUOTES, 'UTF-8'); ?>">Membership</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <h5>FACILITIES</h5>
                        <div class="footer-links d-flex flex-column">
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Health & Fitness</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Sports Facilities</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Swimming Pool</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Indoor Games</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Events</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-left" data-aos-delay="300">
                        <h5>CONNECT</h5>
                        <p style="font-size: 0.85rem;">Subscribe to get updates on events and offers</p>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn" type="button"><i class="bi bi-send-fill"></i></button>
                        </div>
                    </div>
                </div>
                <hr class="my-4" style="background: rgba(197,160,40,0.2);">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0" style="font-size: 0.75rem;">&copy; 2026 North Nazimabad Gymkhana. All rights reserved.</p>
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
