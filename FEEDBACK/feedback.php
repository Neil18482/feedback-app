<?php
session_start();

// Check if the user is logged in as admin
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Feedback List</h2>
    
    <!-- Display logout button if admin is logged in -->
    <?php if ($is_admin): ?>
        <form action="logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    <?php endif; ?>

    <div id="feedbackList"></div>

    <script>
        // Load and display feedbacks
        function loadFeedbacks() {
            fetch('fetch_feedback.php')
                .then(response => response.json())
                .then(data => {
                    let feedbackHTML = '';
                    data.forEach(feedback => {
                        let deleteButton = '';
                        // Only show the delete button if the user is admin
                        if (<?php echo json_encode($is_admin); ?>) {
                            deleteButton = `<button class="delete-btn" onclick="deleteFeedback(${feedback.id})">Delete</button>`;
                        }
                        feedbackHTML += `
                            <div class="feedback-item">
                                <strong>${feedback.name}:</strong> ${feedback.message} <em>(${feedback.created_at})</em>
                                ${deleteButton}
                            </div>
                        `;
                    });
                    document.getElementById('feedbackList').innerHTML = feedbackHTML;
                })
                .catch(error => console.error('Error loading feedback:', error));
        }

        function deleteFeedback(feedbackId) {
            if (confirm('Are you sure you want to delete this feedback?')) {
                fetch('delete_feedback.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        'feedback_id': feedbackId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        loadFeedbacks(); // Reload feedback list after deletion
                    }
                })
                .catch(error => {
                    console.error('Error deleting feedback:', error);
                    alert('Failed to delete feedback.');
                });
            }
        }

        window.onload = loadFeedbacks;
    </script>
</body>
</html>
