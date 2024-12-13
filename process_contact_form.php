<?php
include 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert the data into the contact_submissions table
    $query = "
        INSERT INTO contact_submissions (name, email, message, created_at) 
        VALUES ('$name', '$email', '$message', NOW())
    ";

    if (mysqli_query($conn, $query)) {
        // Redirect to a success page or display a success message
        header('Location: contact_us.php'); // Create this page to show a thank-you message
        exit;
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect back to the form if the request method is not POST
    header('Location: contact.php'); // Replace with your contact form page
    exit;
}
?>
