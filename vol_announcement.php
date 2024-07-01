<?php 
session_start();
include('config/db_connect.php');
include('volunteer_header.php');
if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}

$student_id=$_SESSION['vol_id'];


$announcements = array();

$sql = "SELECT a.*, e.name as event_name
        FROM announcements a
        INNER JOIN event_details e ON a.event_id = e.id
        WHERE e.id IN (
            SELECT vp.event_id
            FROM vol_participate_event vp
            WHERE vp.student_id = $student_id
        )
        ORDER BY a.created_at DESC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $announcements[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Volunteer Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-4 text-center text-green-600">Volunteer Announcements</h1>

        <?php foreach ($announcements as $announcement) { ?>
        <div class="bg-white shadow-md rounded-lg p-6 mb-4">
            <h2 class="text-2xl font-bold mb-2"><?php echo $announcement['title']; ?></h2>
            <p class="text-gray-700 mb-4"><?php echo $announcement['content']; ?></p>
            <p class="text-gray-600 text-sm italic">
                Posted on <?php echo $announcement['created_at']; ?>
                for <?php echo $announcement['event_name']; ?>
            </p>
        </div>
        <?php } ?>
    </div>

</body>

</html>