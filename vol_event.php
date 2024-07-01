<?php
session_start();

if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}
include('config/db_connect.php');
include('volunteer_header.php');

$student_id = $_SESSION['vol_id'];

$currentDate = date('Y-m-d');

$sql = "SELECT ed.date as date, ed.name as name, vp.event_id as event_id, vp.student_id as vol_id, ed.description as description
         FROM vol_participate_event vp
         INNER JOIN event_details ed ON vp.event_id = ed.id
          WHERE vp.student_id = $student_id AND ed.date >= '$currentDate'";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Title Here</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Cards -->
    <div class="container mx-auto mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
           
        ?>

        <div class="bg-white overflow-hidden shadow-md rounded-lg">
            <img class="w-full h-48 object-cover" src="logo/my_event.jpg" alt="Movie">
            <div class="p-6">
                <h1 class="text-2xl font-semibold mb-3"><?php echo $row['name']; ?></h1>
                <p class="text-gray-600 italic"><?php echo $row['description']; ?></p>
                <div class="mt-4">
                    <a href="vol_event_details.php?event_id=<?php echo $row['event_id']; ?>&student_id=<?php echo $row['vol_id']; ?>"
                        class="px-4 py-2 bg-blue-500 text-white rounded">Details</a>
                </div>
            </div>
        </div>

        <?php
        }
        ?>

    </div>

</body>

</html>