<?php
require 'db.php'; // make sure this file contains $pdo or $conn connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect input
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate (simple)
    if (!empty($name) && !empty($phone) && !empty($email) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, phone, email, message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $phone, $email, $message]);
            echo "<script>alert('Thank you! Your message has been received.'); window.location.href='index.html';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: Could not send message.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
    }
} else {
    echo "Invalid request.";
}
?>
