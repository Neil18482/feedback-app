<?php
session_start();

// Unset session variables and destroy the session
session_unset();
session_destroy();

header('Location: login.php'); // Redirect to login page
exit();
