<?php
session_start();

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: feedback.php'); // Redirect to feedback page if already logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hardcoded admin credentials (for demonstration purposes)
    $admin_username = 'admin';
    $admin_password = '1234'; // Use a hashed password for production

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        // Set session to indicate that admin is logged in
        $_SESSION['admin_logged_in'] = true;
        header('Location: feedback.php'); // Redirect to feedback page
        exit();
    } else {
        $error_message = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if (isset($error_message)) { echo '<p style="color: red;">' . $error_message . '</p>'; } ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
