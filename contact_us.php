<?php
include 'config.php';
include 'navbar.php';
?>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .contact-header {
            background: url('./uploads/contact-bg.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 50px 0;
        }

        .contact-header h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .contact-header p {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .form-section {
            padding: 50px 0;
        }

        .info-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        iframe {
            border: 0;
            width: 100%;
            height: 350px;
        }
    </style>

<!-- Header Section -->
<div class="contact-header">
    <h1>Contact Us</h1>
    <p>We'd love to hear from you! Reach out with any questions or inquiries.</p>
</div>

<div class="container form-section">
    <div class="row">
        <!-- Contact Form -->
        <div class="col-md-6">
            <h2>Get in Touch</h2>
            <form action="process_contact_form.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="col-md-6">
            <h2>Our Location</h2>
            <div class="card info-card p-3 mb-4">
                <h5 class="card-title">Address</h5>
                <p class="card-text">123 Luxury Lane, Paradise City, Dreamland 45678</p>
            </div>
            <div class="card info-card p-3 mb-4">
                <h5 class="card-title">Phone</h5>
                <p class="card-text">+123 456 7890</p>
            </div>
            <div class="card info-card p-3 mb-4">
                <h5 class="card-title">Email</h5>
                <p class="card-text">info@luxuryhotel.com</p>
            </div>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434508616!2d144.9630579156717!3d-37.8141079797517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf4c0234457d7a951!2s123%20Luxury%20Lane%2C%20Paradise%20City%2C%20Dreamland!5e0!3m2!1sen!2sus!4v1614211129014!5m2!1sen!2sus" 
                allowfullscreen=""
                loading="lazy"></iframe>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>