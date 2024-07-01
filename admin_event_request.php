<?php

session_start();

include('config/db_connect.php');

$admin_dash = $_SESSION['admin_name'];
if (!$admin_dash) {
    header("Location: adminLogin.php");
    exit();
}

$query = "SELECT id,name FROM event_details WHERE stat = 'pending'";
$queryResult = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accept'])) {
        $eventId = $_POST['id'];
        $getEventDataSql = "SELECT req_club_id, faculty_id FROM event_details WHERE id = $eventId";
        $result = $conn->query($getEventDataSql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reqClubId = $row['req_club_id'];
            $facultyId = $row['faculty_id'];

            $sql = "UPDATE event_details SET stat = 'approved' WHERE id = $eventId";
            if ($conn->query($sql) !== TRUE) {
                echo "Error updating record: " . $conn->error;
                exit();
            }

            if ($reqClubId != 0) {
                // It's a club event
                $insertSql = "INSERT INTO club_host_event (event_id, club_id) VALUES ($eventId, $reqClubId)";
            } elseif ($facultyId != 0) {
                // It's an authority event
                $insertSql = "INSERT INTO authority_host_event (event_id, authority_id) VALUES ($eventId, $facultyId)";
            } else {
                echo "Error: Invalid event data.";
                exit();
            }

            if ($conn->query($insertSql) !== TRUE) {
                echo "Error inserting record: " . $conn->error;
                exit();
            }

            header("Location: admin_event_request.php");
            exit();
        } else {
            echo "Error fetching event data: " . $conn->error;
            exit();
        }
    } elseif (isset($_POST['decline'])) {
        $eventId = $_POST['id'];

        $sql = "UPDATE event_details SET stat = 'declined' WHERE id = $eventId";
        if ($conn->query($sql) === TRUE) {
            header("Location: admin_event_request.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <?php include('admin_header.php') ?>
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-2xl mx-auto bg-white p-8 shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4">Admin Event Requests</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 py-2 px-4">Event ID</th>
                    <th class="border border-gray-300 py-2 px-4">Event Name</th>
                    <th class="border border-gray-300 py-2 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
        
        if ($queryResult->num_rows > 0) {
            while ($rowRes = $queryResult->fetch_assoc()) {
                echo "<tr>
                        <td class='border border-gray-300 py-2 px-4'>
    <a href='admin_event_details.php?id=" . $rowRes["id"] . "' class='text-blue-500 hover:underline'>" . $rowRes["id"] . "</a>
                        </td>
                        <td class='border border-gray-300 py-2 px-4'>" . $rowRes["name"] . "</td>
                        <td class='border border-gray-300 py-2 px-4'>
                            <form action='admin_event_request.php' method='post'>
                                <input type='hidden' name='id' value='" . $rowRes["id"] . "'>
                                <button type='submit' name='accept' class='bg-green-500 text-white px-4 py-2 rounded-md mr-2'>Accept</button>
                                <button type='submit' name='decline' class='bg-red-500 text-white px-4 py-2 rounded-md'>Decline</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='border border-gray-300 py-2 px-4'>No pending events</td></tr>";
        }
        ?>
            </tbody>
        </table>

    </div>

</body>

</html>

<?php

$conn->close();
?>