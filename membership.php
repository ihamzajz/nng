<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>North Nazimabad Gymkhana | Membership</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts - EXQUISITE PAIRING -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS (Animate on Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   <link rel="icon" type="image/png" href="assets/images/icon.png">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body id="top" class="page-membership">
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
        <a href="#top" class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up"></i>
        </a>

        <!-- Navigation -->
        <?php include __DIR__ . '/navbar.php'; ?>

        <!-- Membership Hero Section -->
        <section class="membership-hero" data-aos="fade-up">
            <div class="container">
                <h1>Become a Member</h1>
                <p>Join North Nazimabad Gymkhana - Karachi's premier sports and recreation club. Enjoy world-class facilities, exclusive events, and a vibrant community.</p>
            </div>
        </section>

        <!-- Main Content Container -->
        <section class="container">
            <div class="form-container" data-aos="fade-up" data-aos-delay="100">
                <!-- SUCCESS ALERT (Initially hidden) -->
                <div class="alert-success d-none" id="successAlert">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div>
                        <strong>Application Submitted Successfully!</strong><br>
                        Your membership application has been received. Our team will contact you shortly.
                    </div>
                    <button type="button" class="btn-close ms-auto" onclick="hideAlert()"></button>
                </div>

                <!-- ORIGINAL FORM (Initially visible) -->
                <div id="membershipFormSection">
                    <form id="membershipForm">
                        <!-- Personal Information Section -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="150">
                            <h2><i class="bi bi-person-circle me-2"></i> Personal Information</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fullName" class="form-label required">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fatherName" class="form-label required">Father's Name</label>
                                    <input type="text" class="form-control" id="fatherName" placeholder="Enter father's name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label required">Email Address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label required">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cnic" class="form-label required">CNIC Number</label>
                                    <input type="text" class="form-control" id="cnic" placeholder="XXXXX-XXXXXXX-X" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="dob" class="form-label required">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="gender" class="form-label required">Gender</label>
                                    <select class="form-select" id="gender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="maritalStatus" class="form-label">Marital Status</label>
                                    <select class="form-select" id="maritalStatus">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="divorced">Divorced</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label required">Residential Address</label>
                                    <textarea class="form-control" id="address" rows="3" placeholder="Enter your complete address" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Membership Type Section -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="200">
                            <h2><i class="bi bi-credit-card me-2"></i> Membership Type</h2>
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <div class="membership-type-card" onclick="selectMembershipType('annual', this)">
                                        <h5>Annual</h5>
                                        <div class="membership-price">Rs. 25,000</div>
                                        <div class="membership-duration">12 Months</div>
                                        <p class="small mt-2">Full access to all facilities</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="membership-type-card" onclick="selectMembershipType('half-yearly', this)">
                                        <h5>Half-Yearly</h5>
                                        <div class="membership-price">Rs. 15,000</div>
                                        <div class="membership-duration">6 Months</div>
                                        <p class="small mt-2">All facilities access</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="membership-type-card" onclick="selectMembershipType('quarterly', this)">
                                        <h5>Quarterly</h5>
                                        <div class="membership-price">Rs. 9,000</div>
                                        <div class="membership-duration">3 Months</div>
                                        <p class="small mt-2">Standard facilities access</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="membership-type-card" onclick="selectMembershipType('monthly', this)">
                                        <h5>Monthly</h5>
                                        <div class="membership-price">Rs. 3,500</div>
                                        <div class="membership-duration">1 Month</div>
                                        <p class="small mt-2">Basic facilities access</p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="membershipType" required>
                            <div class="text-danger mt-2 d-none" id="membershipTypeError">
                                Please select a membership type.
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="250">
                            <h2><i class="bi bi-telephone me-2"></i> Emergency Contact</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="emergencyName" class="form-label required">Emergency Contact Name</label>
                                    <input type="text" class="form-control" id="emergencyName" placeholder="Full name of emergency contact" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="emergencyPhone" class="form-label required">Emergency Contact Phone</label>
                                    <input type="tel" class="form-control" id="emergencyPhone" placeholder="Phone number" required>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="300">
                            <h2><i class="bi bi-file-text me-2"></i> Terms & Conditions</h2>
                            
                            <!-- Terms Box -->
                            <div class="terms-box">
                                <p><strong>By submitting this form, I agree to the following terms and conditions:</strong></p>
                                <p>1. I confirm that all information provided is accurate and complete.</p>
                                <p>2. I agree to abide by all club rules and regulations.</p>
                                <p>3. I understand that membership fees are non-refundable.</p>
                                <p>4. I consent to a fitness assessment before using gym facilities.</p>
                                <p>5. I agree to follow safety guidelines while using club facilities.</p>
                                <p>6. I understand that the club reserves the right to terminate membership for misconduct.</p>
                                <p>7. I consent to receive communication from the club via email or phone.</p>
                                <p>8. I agree to inform the club of any changes to my contact or medical information.</p>
                                <p>9. I understand that membership approval is subject to verification of documents.</p>
                                <p>10. I agree to pay membership fees as per the selected plan.</p>
                            </div>
                            
                            <!-- Agree Checkbox -->
                            <div class="form-check mb-3">
                                <input class="form-check-input style-membership-001" type="checkbox" id="agreeTerms" required>
                                <label class="form-check-label style-membership-002" for="agreeTerms">
                                    I have read and agree to the terms and conditions <span class="required"></span>
                                </label>
                                <div class="text-danger mt-1 d-none" id="termsError">
                                    You must agree to the terms and conditions.
                                </div>
                            </div>
                        </div>

                   
                        <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="350">
                            <button type="submit" class="submit-btn">
                                <i class="bi bi-send"></i> Submit Membership Application
                            </button>
                        </div>
                    </form>
                </div>

                
                <div id="confirmationSection" class="d-none new-form-section">
                    <div class="confirmation-section">
                        <div class="confirmation-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h2 class="mb-3 style-membership-003">Application Submitted Successfully!</h2>
                        <p class="lead mb-4 style-membership-004">Thank you for applying to North Nazimabad Gymkhana.</p>
                        
                        <div class="confirmation-details">
                            <h5 class="mb-4 style-membership-005">Application Summary</h5>
                            <div class="detail-item">
                                <span class="detail-label">Application ID:</span>
                                <span class="detail-value" id="appId">North Nazimbad Gymkhana Trust</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Name:</span>
                                <span class="detail-value" id="confirmName">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Membership Type:</span>
                                <span class="detail-value" id="confirmMembership">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Amount:</span>
                                <span class="detail-value" id="confirmAmount">-</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Submission Date:</span>
                                <span class="detail-value" id="confirmDate">-</span>
                            </div>
                        </div>
                        
                        <p class="mb-4 style-membership-006">Our membership team will contact you within 2-3 business days for the next steps.</p>
                        
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <button onclick="submitAnotherApplication()" class="btn btn-outline-primary">
                                <i class="bi bi-plus-circle me-2"></i>Submit Another Application
                            </button>
                            <button onclick="downloadApplication()" class="btn btn-primary">
                                <i class="bi bi-download me-2"></i>Download Application
                            </button>
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
                        <img src="assets/images/NNG.png" alt="Logo" class="mb-3 style-membership-007">
                        <p>North Nazimabad Gymkhana — excellence in sports, fitness, and community.</p>
                        <div class="social-icons mt-4">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana "target="_blank"><i class="bi bi-facebook"></i></a>
                          
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
    </div> <!-- End of .main-content -->

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS (Animate on Scroll) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script src="assets/js/main.js"></script>
</body>
</html>
