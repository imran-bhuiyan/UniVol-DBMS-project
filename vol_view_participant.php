<?php
session_start();
if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}

include('config/db_connect.php');
include('volunteer_header.php');

$event_id;


if (isset($_GET['event_id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['event_id']);
}

$sql_participants = "SELECT vol.student_id as id, vol.name as name, vol.points as point, vol.email as email FROM vol_participate_event vp INNER JOIN volunteer vol ON vp.student_id=vol.student_id WHERE vp.event_id = $event_id";

$result_participants = mysqli_query($conn, $sql_participants);

$participants = [];
while ($row = mysqli_fetch_assoc($result_participants)) {
    $participants[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Participants</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-4 text-center">
        <h2 class="text-2xl font-bold mb-3">Participants List</h2>
    </div>

    <div class="container mx-auto mt-4">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>SL No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    <?php foreach ($participants as $participant) { ?>
                    <tr>
                        <td><?php echo $index; ?></td>
                        <td><?php echo $participant['name']; ?></td>
                        <td class="italic"><a
                                href="mailto:<?php echo $participant['email']; ?>"><?php echo $participant['email']; ?></a>
                        </td>
                        <td><?php echo $participant['point']; ?></td>
                    </tr>
                    <?php $index++; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>