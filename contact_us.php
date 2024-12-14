<?php
include 'config.php';
include 'navbar.php';
?>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .contact-header {
            background: url('./uploads/contact-bg.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 60px 0;
        }

        .contact-header h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .contact-header p {
            font-size: 1.3rem;
            margin-top: 10px;
        }

        .form-section {
            padding: 60px 0;
        }

        .info-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        iframe {
            border: 0;
            width: 100%;
            height: 350px;
            margin-top: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: none;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>

<!-- Header Section -->
<div class="contact-header">
    <h1>Contact Us</h1>
    <p>We'd love to hear from you! Reach out with any questions, inquiries, or requests for assistance.</p>
</div>

<div class="container form-section">
    <div class="row">
        <!-- Contact Form -->
        <div class="col-md-6">
            <h2>Get in Touch</h2>
            <p>Have a question or need assistance? We're here to help! Fill out the form below, and one of our team members will respond shortly.</p>
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
            <p>We are conveniently located in the beautiful and vibrant "Cordova, Cebu City". Visit us or get in touch with the details below:</p>

            <div class="card info-card p-3 mb-4">
                <h5 class="card-title">Address</h5>
                <p class="card-text">Gabi, Cordova, Cebu City, Philippines</p>
            </div>
            <div class="card info-card p-3 mb-4">
                <h5 class="card-title">Phone</h5>
                <p class="card-text">+123 456 7890</p>
            </div>
            <div class="card info-card p-3 mb-4">
                <h5 class="card-title">Email</h5>
                <p class="card-text">info@cpchotels.com</p>
            </div>

            <!-- Google Map for Cordova, Cebu City -->
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.7591638983467!2d123.93263221478964!3d10.295130092152858!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33aa6a49b79ff45b%3A0x12a02b3881781b0a!2sCordova%2C%20Cebu%2C%20Philippines!5e0!3m2!1sen!2sus!4v1614212124135!5m2!1sen!2sus" 
                allowfullscreen=""
                loading="lazy"></iframe>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>