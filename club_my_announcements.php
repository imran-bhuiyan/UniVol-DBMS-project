<?php
session_start();
if (!isset($_SESSION['user_id'])) {
   
    header("Location: clubLogin.php");
    exit();
}

include('config/db_connect.php');

$club_id = $_SESSION['user_id'];

// Fetch announcements for the club
$sql = "SELECT * FROM announcements WHERE club_id = '$club_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<?php include('club_header.php'); ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVol - My Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <section class="container mx-auto mt-6 text-gray-800">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto">
            <h4 class="text-2xl font-bold text-center">My Announcements</h4>

            <?php
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="mb-4">';
                    echo '<p><strong>Event ID:</strong> ' . htmlspecialchars($row['event_id']) . '</p>';
                    echo '<p><strong>Title:</strong> ' . htmlspecialchars($row['title']) . '</p>';
                    echo '<p><strong>Content:</strong> ' . htmlspecialchars($row['content']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No announcements available.</p>';
            }
            ?>

            <div class="text-center mt-4">
                <a href="club_event_details.php" class="link link-hover text-blue-500">Back to Home</a>
            </div>
        </div>
    </section>

</body>

</html>