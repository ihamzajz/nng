<?php require_once __DIR__ . '/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="North Nazimabad Gymkhana - Premier fitness, sports, and community destination in Karachi. Established in 2007, offering world-class facilities and professional coaching.">
    <title>North Nazimabad Gymkhana | Heritage of Excellence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/public-refresh.css'), ENT_QUOTES, 'UTF-8'); ?>">
    <style>
        .vision-mission-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f8f5f0 0%, #fffdf9 100%);
            border-top: 1px solid rgba(197, 160, 40, 0.2);
            border-bottom: 1px solid rgba(197, 160, 40, 0.2);
        }

        .vision-card,
        .mission-card {
            background: #fff;
            border-radius: 32px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            height: 100%;
            border: 1px solid rgba(197, 160, 40, 0.15);
            position: relative;
            overflow: hidden;
        }

        .vision-card:hover,
        .mission-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 28px 40px -15px rgba(0, 0, 0, 0.12);
            border-color: rgba(197, 160, 40, 0.4);
        }

        .vision-card::before,
        .mission-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(135deg, #c5a028, #e6c85c);
            border-radius: 32px 0 0 32px;
        }

        .vision-icon,
        .mission-icon {
            font-size: 3rem;
            color: #c5a028;
            margin-bottom: 1.5rem;
        }

        .vision-title,
        .mission-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 2rem;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
            color: #1a2a3a;
        }

        .vision-text,
        .mission-text {
            color: #4a5b6e;
            line-height: 1.7;
            font-size: 1rem;
            margin: 0;
        }

        .objectives-wrapper {
            margin-top: 3rem;
            background: #fff;
            border-radius: 40px;
            padding: 2.5rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(197, 160, 40, 0.2);
        }

        .objectives-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1.9rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #1a2a3a;
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .objectives-title::after {
            content: '';
            display: block;
            width: 70px;
            height: 3px;
            background: #c5a028;
            margin: 0.8rem auto 0;
            border-radius: 2px;
        }

        .objectives-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .objective-item {
            background: #fefcf8;
            padding: 1.25rem 1.5rem;
            border-radius: 24px;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            border-left: 3px solid #c5a028;
        }

        .objective-item:hover {
            background: #fff;
            transform: translateX(6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .objective-icon {
            font-size: 1.8rem;
            color: #c5a028;
            min-width: 45px;
            text-align: center;
        }

        .objective-text {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.5;
            color: #2c3e44;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .vision-mission-section {
                padding: 3rem 0;
            }

            .vision-card,
            .mission-card {
                padding: 1.8rem;
            }

            .objectives-wrapper {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body class="page-about">
    <div id="loading-page">
        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="North Nazimabad Gymkhana" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        <div class="loading-text">EST. 2007<span class="loading-dots"></span></div>
    </div>

    <div class="main-content">
        <a href="#" class="back-to-top" id="backToTop" aria-label="Back to top">
            <i class="bi bi-arrow-up-short"></i>
        </a>

        <?php include __DIR__ . '/navbar.php'; ?>

        <section class="section-header" data-aos="fade-up" data-aos-duration="800">
            <h1>Legacy of Distinction</h1>
            <p>Where heritage meets vitality, a sanctuary for wellness, community, and sporting excellence since 2007.</p>
        </section>

        <div class="container" data-aos="fade-up" data-aos-delay="150">
            <div class="history-card">
                <div class="history-text">
                    <p>Since North Nazimabad Gymkhana lies in your administrative jurisdiction, we Founder Members / Trustees of NNGT, feel that we should keep our District Administration aware of the ground reality. Local administration must know about North Nazimabad Gymkhana and its activities, and how North Nazimabad Gymkhana was established and developed, who took initiative to provide such amiable facility for the vicinity of masses living in District Central.</p>
                    <p>Back in 1958 this piece of Land was allotted to Muslim Commercial Bank to develop sports complex, but unfortunately due to lack of interest this land has occupied by nomads (Khanabadoosh).</p>
                    <p>In 1992 few notable conceived an idea to utilized this land for benefit of North Nazimabad people and approached to the than local Government, due to some political reasons it was not materialized, later on again in 2007 it was reinitiated by the same notable of this area to develop Gymkhana.</p>
                    <p>For this purpose we founder member invited Prime Minister of Pakistan Mr. Shoukat Aziz for ground breaking in October 2007 alongwith his Federal Cabinet Members, Senator Babar Gouri, Mr. Shamim Siddiqui the than Federal Minister, the then Governor of Sindh Dr. Ishrat ul Ibad, Chief Minister Sindh Dr. Arbab Rahim, alongwith his provincial cabinet members. Mayor, CDGK Mr. Mustufa Kamal accompanied by Local District Administration, whereas Chief Minister Sindh Dr. Arbab Rahim pledged Rs. 50.00 (M) as official support the Gymkhana establishment, from that amount we (Founder Members) built a Gymkhana Building equipped it with imported Gym equipment and developed several other sports facilities.</p>
                    <p>Meanwhile this piece of Land was officially handed over to the Founder Member Mr. Feroze Alam Lari, Capt. Moiz Khan in 2009 through passing a CDGK Govt. resolution 445 dated 24-01-2009 and endorsed it by signing an official lease agreement in 2010 for 30 years on rental basis in a handing over event.</p>
                    <p>The founder members played vital role in the establishment of this Gymkhana and personally raised funds by contributing among them amounting to Rs. 1.00 (M) each in 2010 and later on to safeguard the funds, Founder Members decided to register a trust with Registrar North Nazimabad as North Nazimabad Gymkhana Trust No. 184 (IV), dated 19-02-2015 M. F. Roll No. 21724/9962 dated 14-04-2015.</p>
                    <p>Further in 2018 Founders members made rigorously efforts to have sports complex of international standards with the collaboration of Govt. of Sindh they've constructed a squash and badminton complex, which was inaugurated by the than Hon. Mayor of Karachi Barrister Murtuza Wahab.</p>
                    <p>However in the year 2020 on the demand of FATF Government of Sindh as passed an Act known as Sindh Govt. Act 2020 for re-registration of Trust under this act, it was mandatory, hence our Board of Directors decided to comply the instructions of Sindh Govt. and furnished our application for re-registration of our existing Trust Deed.</p>
                    <p>Now, as the re-registration is underway we are running Gymkhana under the By-Laws defined in our Trust Deed. Now Gymkhana is fully operational now Alhamdulilah we have around 1500 members.</p>
                    <p>We the Founder's members and Trustees of North Nazimabad Gymkhana Trust are grateful to Almighty Allah that we achieved our goals with HIS blessings.</p>
                    <p><strong>Thanks!</strong></p>
                </div>
            </div>
        </div>

        <section class="members-wrapper">
            <div class="container">
                <div class="members-card" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="members-title">Guardians of Excellence</h2>
                    <ul class="members-list">
                        <li><strong>Mr. Shamim Siddiqui</strong> <span class="role">&mdash; President,</span> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Ahmed Ali Khan</strong> <span class="role">&mdash; General Secretary,</span> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Syed Majid Humail</strong> <span class="role">&mdash; Treasurer,</span> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Moazzam Ali Saad</strong> <span class="role">&mdash; Secretary / Administrator,</span> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Senator Amir Waliuddin Chishti</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Feroze Alam Lari</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Muhammad Akhter</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Syed Usman Ali</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Abdul Rasheed</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Samir Gulzar</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Muhammad Saleem</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mr. Rehan Mansoor</strong> <span class="suffix">FM/Trustee NNGT</span></li>
                        <li><strong>Mrs. Asma Ali Shah</strong> <span class="suffix">Nominee Member</span></li>
                    </ul>
                    <div class="members-footer">Est. 2018 | North Nazimabad Gymkhana Trust</div>
                </div>
            </div>
        </section>

        <section class="vision-mission-section" data-aos="fade-up" data-aos-delay="250">
            <div class="container">
                <div class="row g-4 mb-5">
                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="300">
                        <div class="vision-card">
                            <div class="vision-icon"><i class="bi bi-eye-fill"></i></div>
                            <h3 class="vision-title">Vision</h3>
                            <p class="vision-text">To be a leading recreational and sports institution that promotes a healthy, active, and socially connected lifestyle for residents of North Nazimabad and all over Pakistan.</p>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="350">
                        <div class="mission-card">
                            <div class="mission-icon"><i class="bi bi-bullseye"></i></div>
                            <h3 class="mission-title">Mission</h3>
                            <p class="mission-text">To provide high-quality sports, fitness, and recreational facilities in a safe, inclusive, and family-friendly environment, while promoting physical well-being, social interaction, and community development across Pakistan.</p>
                        </div>
                    </div>
                </div>

                <div class="objectives-wrapper" data-aos="fade-up" data-aos-delay="400">
                    <h3 class="objectives-title">Our Strategic Objectives</h3>
                    <div class="objectives-grid">
                        <div class="objective-item">
                            <div class="objective-icon"><i class="bi bi-building"></i></div>
                            <p class="objective-text">To develop, manage, and maintain modern sports and recreational facilities for members and visitors.</p>
                        </div>
                        <div class="objective-item">
                            <div class="objective-icon"><i class="bi bi-heart-pulse"></i></div>
                            <p class="objective-text">To promote health, fitness, and well-being among individuals of all age groups across Pakistan.</p>
                        </div>
                        <div class="objective-item">
                            <div class="objective-icon"><i class="bi bi-shield-check"></i></div>
                            <p class="objective-text">To provide a safe, secure, and family-oriented environment for recreational and social activities.</p>
                        </div>
                        <div class="objective-item">
                            <div class="objective-icon"><i class="bi bi-trophy"></i></div>
                            <p class="objective-text">To organize sports events, tournaments, and cultural programs to encourage community participation.</p>
                        </div>
                        <div class="objective-item">
                            <div class="objective-icon"><i class="bi bi-people"></i></div>
                            <p class="objective-text">To foster social cohesion, networking, and community engagement among members.</p>
                        </div>
                        <div class="objective-item">
                            <div class="objective-icon"><i class="bi bi-graph-up"></i></div>
                            <p class="objective-text">To continuously improve and expand facilities in line with modern standards and community needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="why-choose-us">
            <div class="container">
                <div class="row mb-5 text-center" data-aos="fade-up">
                    <div class="col-12">
                        <h2 class="section-title">The Distinguished Advantage</h2>
                        <p class="lead" style="color: var(--slate);">Curated for those who demand excellence in recreation and well-being.</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-card">
                            <div class="icon-circle"><i class="bi bi-clock-fill"></i></div>
                            <h4>Extended Hours</h4>
                            <p>12-hour daily access, 7 days a week. Designed for professionals and families seeking flexibility.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-card">
                            <div class="icon-circle"><i class="bi bi-shield-lock-fill"></i></div>
                            <h4>Elite Security</h4>
                            <p>24/7 surveillance, trained personnel, and controlled access, a sanctuary of safety.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-card">
                            <div class="icon-circle"><i class="bi bi-trophy-fill"></i></div>
                            <h4>Certified Coaches</h4>
                            <p>Professional trainers across squash, swimming, fitness, and badminton for peak performance.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="feature-card">
                            <div class="icon-circle"><i class="bi bi-gear-wide-connected"></i></div>
                            <h4>Premium Equipment</h4>
                            <p>State-of-the-art fitness machinery and sports infrastructure maintained to global standards.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                        <div class="feature-card">
                            <div class="icon-circle"><i class="bi bi-calendar-week-fill"></i></div>
                            <h4>Elite Events</h4>
                            <p>Annual tournaments, galas, and networking evenings that foster community bonds.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                        <div class="feature-card">
                            <div class="icon-circle"><i class="bi bi-award-fill"></i></div>
                            <h4>Award-Winning Legacy</h4>
                            <p>Recognized excellence in sports development and member satisfaction across Karachi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4" data-aos="fade-right">
                        <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="NNG" class="footer-logo mb-3">
                        <p style="font-size: 0.9rem; opacity: 0.8;">North Nazimabad Gymkhana where tradition meets modern fitness. A trusted institution since 2007.</p>
                        <div class="social-icons mt-3">
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.facebook.com/NorthNazimabadGymkhana" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.youtube.com/@NNG_SPORTS_CLUB-tn6ew" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
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
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Fitness Studio</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Squash Complex</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Swimming Pool</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Badminton Courts</a>
                            <a href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Community Events</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-left" data-aos-delay="300">
                        <h5>CONNECT WITH US</h5>
                        <p style="font-size: 0.85rem;">Subscribe to receive invitations to exclusive tournaments and wellness insights.</p>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email address" aria-label="Email subscription">
                            <button class="btn" type="button"><i class="bi bi-send-fill"></i></button>
                        </div>
                    </div>
                </div>
                <hr class="my-4" style="background: rgba(197,160,40,0.2);">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0" style="font-size: 0.75rem;">&copy; 2026 North Nazimabad Gymkhana Trust. All rights reserved. A legacy of excellence.</p>
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
