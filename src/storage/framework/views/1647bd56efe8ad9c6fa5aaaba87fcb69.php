<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concord Hospital</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
        <!-- Theme + Landing Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/landing.css')); ?>">
</head>
<body>
<!-- Header -->
<header>
    <div class="container">
        <nav>
            <div class="logo">Concord Hospital</div>
            <ul>
                <li>
                    <a href="#home" class="btn btn-call">
                        <i class="bi bi-telephone-fill"></i> Call Us
                    </a>
                </li>
                <li>
                    <a href="#about" class="btn btn-book">
                        <i class="bi bi-calendar-check-fill"></i> Book Now
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- Sub Navigation -->
<div class="sub-nav">
    <div class="container">
        <a href="#services" class="sub-link">Home</a>
        <a href="#doctors" class="sub-link">Find a Doctor</a>
        <a href="#appointments" class="sub-link">Services</a>
        <a href="#contact" class="sub-link">Patients Resources</a>
    </div>
</div>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container hero-content">
        <div class="hero-text">
            <h1>Trusted Care for Every Patient</h1>
            <p>
                Concord Hospital delivers compassionate, patient-centered
                healthcare with modern facilities and experienced professionals.
            </p>
        </div>

        <div class="hero-image">
            <img src="<?php echo e(asset('images/achievment.jpeg')); ?>" alt="Healthcare Professionals">
        </div>
    </div>
</section>

<!-- Features / Services -->
<section class="features container" id="services">
    <div class="feature">
        <h3>24/7 Emergency Care</h3>
        <p>
            Our emergency department operates around the clock with
            rapid-response medical teams.
        </p>
    </div>

    <div class="feature">
        <h3>Expert Medical Staff</h3>
        <p>
            Board-certified physicians and specialists committed to
            patient safety and excellence.
        </p>
    </div>

    <div class="feature">
        <h3>Modern Facilities</h3>
        <p>
            Advanced diagnostic and treatment technology designed
            for comfort and accuracy.
        </p>
    </div>
</section>

<!-- Additional Sections -->
<section id="doctors" class="container">
    <h2>Our Doctors</h2>
</section>

<section id="appointments" class="container">
    <h2>Book an Appointment</h2>
</section>

<section id="contact" class="container">
    <h2>Contact Us</h2>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; 2025 CityCare Hospital. All rights reserved.</p>
        <p>
            <a href="#privacy">Privacy Policy</a> |
            <a href="#terms">Terms of Service</a>
        </p>
    </div>
</footer>

<!-- Sub NavLink Highlight JS -->
<script>
    const sections = document.querySelectorAll("section[id]");
    const subLinks = document.querySelectorAll(".sub-link");

    window.addEventListener("scroll", () => {
        let scrollPos = window.scrollY + 150;
        sections.forEach(section => {
            if(scrollPos >= section.offsetTop && scrollPos < section.offsetTop + section.offsetHeight){
                subLinks.forEach(link => {
                    link.classList.remove("active");
                    if(link.getAttribute("href") === "#" + section.id){
                        link.classList.add("active");
                    }
                });
            }
        });
    });
</script>

</body>
</html>
<?php /**PATH /var/www/resources/views/landing/landing.blade.php ENDPATH**/ ?>