<?php
// Include the configuration and session
include 'config.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    die('Unauthorized access');
}

$user_id = $_SESSION['user']['id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $room_id = (int)$_POST['room_id'];
    // Collect and validate user input
    $age = isset($_POST['age']) ? (int) $_POST['age'] : null;
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $address = isset($_POST['address']) ? trim($_POST['address']) : null;
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;

    // Validate required fields
    $errors = [];
    if ($age === null || $age <= 0) {
        $errors[] = 'Age must be a valid number.';
    }
    if ($birthdate === null || strtotime($birthdate) === false) {
        $errors[] = 'Birthdate is invalid.';
    }
    if ($gender === null || !in_array($gender, ['male', 'female', 'other'])) {
        $errors[] = 'Gender must be valid.';
    }
    if ($address === null || strlen($address) < 5) {
        $errors[] = 'Address must be at least 5 characters.';
    }
    if ($phone_number === null || !preg_match('/^[0-9]{10,15}$/', $phone_number)) {
        $errors[] = 'Phone number must be between 10 to 15 digits.';
    }

    // If there are validation errors, return to the previous page
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: view_room.php?id=$room_id"); // Replace with your previous page
        exit;
    }

    // Update the user's details in the database
    $query = "UPDATE users SET 
                age = ?, 
                birthdate = ?, 
                gender = ?, 
                address = ?, 
                phone_number = ? 
              WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('issssi', $age, $birthdate, $gender, $address, $phone_number, $user_id);

    if ($stmt->execute()) {
        // Success
        $_SESSION['success'] = 'Profile updated successfully.';
        header("Location: view_room.php?id=$room_id"); // Redirect back to the reservation page
        exit;
    } else {
        // Error
        $_SESSION['error'] = 'Failed to update profile. Please try again later.';
        header("Location: view_room.php?id=$room_id"); // Replace with your previous page
        exit;
    }
} else {
    // Invalid request method
    die('Invalid request method');
}
?>
