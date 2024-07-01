<?php
session_start();

include('config/db_connect.php');
$admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $eventId = $_GET['id'];

   
    $sql = "SELECT * FROM event_details WHERE id = $eventId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $eventDetails = $result->fetch_assoc();

    } else {
        echo "Event not found.";
    }
} else {
    echo "Invalid request.";
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <?php include('admin_header.php') ?>
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-2xl mx-auto bg-white p-8 shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Event Details</h2>
        <!-- showing table here -->
        <?php if (isset($eventDetails) && !empty($eventDetails)) : ?>
        <table class="w-full border-collapse border border-gray-300">
            <tbody>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Event ID</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['id'] ?></td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Event Name</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['name'] ?></td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Description</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['description'] ?></td>
                </tr>

                <tr>
                    <th class="border border-gray-300 py-2 px-4">Required Skills</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['req_skill'] ?></td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Date</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['date'] ?></td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Time</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['time'] ?></td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Location</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['location'] ?></td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Volunteer Required</th>
                    <td class="border border-gray-300 py-2 px-4"><?= $eventDetails['vol_count'] ?></td>
                </tr>

            </tbody>
        </table>
        <?php else : ?>
        <p>No event details available.</p>
        <?php endif; ?>

    </div>
    <div class="text-center mt-4">
        <a href="admin_event_request.php" class="link link-hover text-blue-500 ">Back to Request Page</a>
    </div>

</body>

</html>