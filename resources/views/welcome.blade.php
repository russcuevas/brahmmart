<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>Brahmmart</title>
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/customers/welcome.css') }}">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="logo-container">
            <img src="{{ asset('logo-plain.png') }}" alt="Brahmmart Logo">
            <span class="logo-text">BRAHMMART</span>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#categories">Shop</a></li>
            <li><a href="#id-status">ID Scheduling</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="mobile-only"><a href="#" class="btn-primary">Sign In</a></li>
        </ul>
        <div class="nav-actions">
            <a href="#" class="btn-primary desktop-only" style="padding: 0.6rem 1.5rem; font-size: 0.9rem;">Sign
                In</a>
            <div class="mobile-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="mobile-overlay" id="menu-overlay"></div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="{{ asset('banner-vid.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>

    </section>

    <!-- About Section -->
    <section id="about" class="about" aria-labelledby="about-heading">
        <div class="about-container">
            <div class="about-content">
                <span class="about-badge">About Brahmmart</span>
                <h2 id="about-heading" class="about-title">Empowering <span class="text-gradient">Brahman
                        Excellence</span> Through Quality & Service</h2>
                <p class="about-text">
                    Brahmmart is the premier student-centric platform dedicated to the University of Batangas community.
                    We provide high-quality, official school uniforms and essential academic supplies that uphold the
                    tradition of excellence.
                </p>
                <div class="about-features">
                    <div class="feature-item">
                        <div class="feature-icon" aria-hidden="true"><i class="fas fa-check-circle"></i></div>
                        <div class="feature-info">
                            <h4>Official UB Uniforms</h4>
                            <p>Authentic, durable, and perfectly tailored for every student.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon" aria-hidden="true"><i class="fas fa-id-card"></i></div>
                        <div class="feature-info">
                            <h4>ID & Document Services</h4>
                            <p>Streamlined scheduling for ID pickups and student services.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon" aria-hidden="true"><i class="fas fa-pencil-alt"></i></div>
                        <div class="feature-info">
                            <h4>School Supplies</h4>
                            <p>Quality stationary and essential tools for your academic success.</p>
                        </div>
                    </div>
                </div>
                <a href="#categories" class="btn-primary">Explore Shop</a>
            </div>
            <div class="about-images">
                <div class="image-grid">
                    <div class="img-large">
                        <img src="{{ asset('about-banner.jpg') }}" alt="UB Students" class="fade-img active">
                        <img src="{{ asset('assets/images/about/about-banner-4.jpg') }}" alt="UB Excellence"
                            class="fade-img">
                        <div class="img-caption">University Excellence</div>
                    </div>
                    <div class="img-small">
                        <img src="{{ asset('assets/images/about/about-banner.png') }}" alt="Official Uniforms">
                    </div>
                    <div class="img-floating">
                        <img src="{{ asset('assets/images/about/about-banner-2.png') }}" alt="ID Services">
                    </div>
                    <!-- Decorative Elements -->
                    <div class="shape-blob"></div>
                    <div class="shape-dots"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories">
        <div class="section-header">
            <h2>Shop by Category</h2>
            <p>Explore our wide range of high-quality school essentials tailored for your academic success.</p>
        </div>
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <h3>Official Uniforms</h3>
                <p>Perfectly tailored uniforms designed for comfort and durability throughout the school year.</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3>Textbooks</h3>
                <p>Complete set of curriculum books and reference materials for all grade levels.</p>
            </div>
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <h3>School Supplies</h3>
                <p>Everything from stationary to backpacks, curated for the modern student.</p>
            </div>
        </div>
    </section>

    <!-- ID Scheduling Section -->
    <section id="id-status">
        <div class="id-section">
            <div class="id-content">
                <span class="id-status-badge">New Service</span>
                <h2 style="font-size: 3rem; margin-bottom: 1.5rem;">ID Pickup <span
                        class="text-gradient">Scheduling</span></h2>
                <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 2rem;">
                    Skip the long queues! You can now check if your school ID is ready for pickup and schedule a
                    convenient time to collect it.
                </p>
                <a href="javascript:void(0)" class="btn-primary" id="how-it-works-btn">How it works</a>
            </div>
            <div class="id-image">
                <div class="id-card-wrapper">
                    <div class="id-card-img">
                        <img src="{{ asset('assets/images/id/ub-batangas-id.png') }}" alt="UB Batangas ID">
                    </div>
                    <div class="id-card-info">
                        <span>Batangas Campus</span>
                        <h4>Official Student ID</h4>
                    </div>
                </div>
                <div class="id-card-wrapper">
                    <div class="id-card-img">
                        <img src="{{ asset('assets/images/id/ub-lipa-id.png') }}" alt="UB Lipa ID">
                    </div>
                    <div class="id-card-info">
                        <span>Lipa Campus</span>
                        <h4>Official Student ID</h4>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="id-shape-blob"></div>
                <div class="id-shape-dots"></div>
                <div class="id-shape-ring"></div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <div class="cta-banner">
        <img src="{{ asset('assets/images/cta/CTA.png') }}" alt="Call to Action">
        <div class="cta-overlay">
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Ready to gear up?</h2>
            <p style="margin-bottom: 2rem; opacity: 0.9;">Join thousands of students who trust Brahmmart for their
                academic needs.</p>
            <div>
                <a href="#" class="btn-primary">Get Started Now</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-grid">
            <div class="footer-brand">
                <h2>BRAHMMART</h2>
                <p style="color: var(--text-muted);">The leading provider of quality school essentials and student
                    services.</p>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#categories">Shop</a></li>
                    <li><a href="#id-status">ID Status</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Connect</h4>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" style="font-size: 1.5rem;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="font-size: 1.5rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="font-size: 1.5rem;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            &copy; 2026 Brahmmart. All rights reserved. Designed for Excellence.
        </div>
    </footer>
    <!-- How It Works Modal -->
    <div class="modal-overlay" id="how-it-works-modal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>How ID Scheduling Works</h3>
                <button class="modal-close" id="close-modal">&times;</button>
            </div>
            <div class="modal-content">
                <div class="steps-timeline">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-text">
                            <h4>Step 1: Picture Yourself</h4>
                            <p>Capture a high-quality photo of yourself wearing formal attire. Ensure good lighting and
                                a plain background for the best ID quality.</p>
                        </div>
                        <div class="step-img">
                            <img src="https://i.pinimg.com/474x/3a/74/85/3a74857ee413c986606ff6a7fa83329c.jpg"
                                alt="Step 1">
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-text">
                            <h4>Step 2: Provide Your Signature</h4>
                            <p>Sign on a clean piece of white paper, take a clear photo of it, and crop it to focus on
                                the signature itself.</p>
                        </div>
                        <div class="step-img">
                            <img src="https://content-management-files.canva.com/4f4223e6-64c3-4006-8670-7cfc9697dcd9/product_electronic-signature_how-to2x.png"
                                alt="Step 2">
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-text">
                            <h4>Step 3: Upload at BRAHMMART ID PORTAL</h4>
                            <p>Upload your photo and signature to the BRAHMMART ID PORTAL</p>
                        </div>
                        <div class="step-img">
                            <img src="{{ asset('assets/images/id/id-portal.png') }}" alt="Step 3">
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-text">
                            <h4>Step 4: Wait for the admin approval and setting possible pickup date and time</h4>
                            <p>Your ID will be ready in 2-3 working days.</p>
                        </div>
                        <div class="step-img">
                            <img src="https://img.favpng.com/1/3/24/check-mark-scalable-vector-graphics-transparency-computer-icons-png-favpng-hKbZKgtYkdWPCDpBECiYzLfzd.jpg"
                                alt="Step 4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.querySelector('.nav-links');
        const menuOverlay = document.getElementById('menu-overlay');

        function toggleMenu() {
            menuToggle.classList.toggle('active');
            navLinks.classList.toggle('active');
            menuOverlay.classList.toggle('active');
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : 'auto';
        }

        menuToggle.addEventListener('click', toggleMenu);
        menuOverlay.addEventListener('click', toggleMenu);

        // Close menu when a link is clicked
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                if (navLinks.classList.contains('active')) toggleMenu();
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.style.padding = '0.8rem 5%';
                nav.style.background = '#752738';
                nav.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
            } else {
                nav.style.padding = '1.2rem 5%';
                nav.style.background = 'transparent';
                nav.style.boxShadow = 'none';
            }
        });

        // About Image Slider
        const fadeImgs = document.querySelectorAll('.img-large .fade-img');
        let currentImgIndex = 0;
        if (fadeImgs.length > 1) {
            setInterval(() => {
                fadeImgs[currentImgIndex].classList.remove('active');
                currentImgIndex = (currentImgIndex + 1) % fadeImgs.length;
                fadeImgs[currentImgIndex].classList.add('active');
            }, 3000);
        }
        // Modal Logic
        const modal = document.getElementById('how-it-works-modal');
        const openBtn = document.getElementById('how-it-works-btn');
        const closeBtn = document.getElementById('close-modal');

        openBtn.addEventListener('click', () => {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>

</html>
