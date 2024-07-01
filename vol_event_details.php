<?php
session_start();
include('config/db_connect.php');
include('volunteer_header.php');

if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}

$event_id='';
if (isset($_GET['event_id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['event_id']);

    }
    $sql_event = "SELECT * FROM event_details WHERE id = $event_id";
    $result_event = mysqli_query($conn, $sql_event);

    
$event = mysqli_fetch_assoc($result_event);
  


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Headline -->
    <div class="container mx-auto mt-4 text-center">
        <h2 class="text-2xl font-bold mb-3">My Event Details</h2>
    </div>

    <!-- Event Details in a Card -->
    <div class="container mx-auto flex justify-center">
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-semibold text-blue-500">Name: <?php echo $event['name']; ?>
                </h2>

                <p> <b>Date: </b><?php echo $event['date']; ?></p>
                <p><b>Time: </b><?php echo $event['time']; ?></p>
                <p><b>Location: </b><?php echo $event['location']; ?></p>
                <p><b>Registered Volunteer:
                    </b><?php echo $event['vol_count']-$event['remaining_member']; ?>
                </p>

                <p class="mt-4">
                    <a href="vol_view_participant.php?event_id=<?php echo $event['id']; ?>" class="text-blue-500">View
                        Participants</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>