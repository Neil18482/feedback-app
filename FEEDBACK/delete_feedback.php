<?php
session_start();
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$database = "feedback_db";

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    die(json_encode(["success" => false, "message" => "You must be logged in as an admin to delete feedback."]));
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}

// Ensure the request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die(json_encode(["success" => false, "message" => "Invalid request method."]));
}

// Check if feedback ID exists
if (isset($_POST['feedback_id']) && !empty($_POST['feedback_id'])) {
    $feedback_id = $_POST['feedback_id'];

    // Delete feedback from database
    $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ?");
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Feedback deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete feedback."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Feedback ID is required."]);
}

$conn->close();
?>
