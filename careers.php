<?php
require 'db.php'; // make sure this sets up $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $position = htmlspecialchars(trim($_POST['status']));
    $experience = (int) $_POST['experience'];
    $details = htmlspecialchars(trim($_POST['details']));
    $resumePath = "";

    // Handle file upload
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = basename($_FILES['fileToUpload']['name']);
        $fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $fileName); // sanitize file name
        $targetPath = $uploadDir . $fileName;

        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx'];

        if (in_array($fileType, $allowed)) {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetPath)) {
                $resumePath = $targetPath;
            } else {
                echo "<script>alert('Failed to upload resume.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file format. Only PDF, DOC, and DOCX allowed.'); window.history.back();</script>";
            exit;
        }
    }

    // Insert into DB
    try {
        $stmt = $pdo->prepare("INSERT INTO careers (name, phone, email, position, experience, details, resume) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $email, $position, $experience, $details, $resumePath]);
        echo "<script>alert('Application submitted successfully!'); window.location.href='careers.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Database error: Could not save your application.'); window.history.back();</script>";
    }

} else {
    echo "Invalid request.";
}
?>
