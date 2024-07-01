<?php
session_start();


if (!isset($_SESSION['autho_id'])) {
    header("Location: authoritylogin.php"); 
    exit();
}

include('config/db_connect.php');

$autho_id = $_SESSION['autho_id'];


$currentDate = date('Y-m-d'); 

$query = "SELECT ahe.event_id, ed.name
          FROM authority_host_event ahe 
          INNER JOIN event_details ed ON ahe.event_id = ed.id 
          WHERE ahe.authority_id = $autho_id AND ed.date >= '$currentDate'";
$result = $conn->query($query);



// Check if any events are hosted by the club
if ($result->num_rows > 0) {
    $events = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $events = []; 
}


if (isset($_GET['event_id'])) {
    $selectedEventId = $_GET['event_id'];
    // Fetch 
    $queryVolunteers = "SELECT v.student_id, v.name ,v.email FROM volunteer v
                        INNER JOIN vol_participate_event vpe ON v.student_id = vpe.student_id
                        WHERE vpe.event_id = $selectedEventId";
    $resultVolunteers = $conn->query($queryVolunteers);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('authority_header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100">
    <section class="container mx-auto my-8 p-8 bg-white shadow-md rounded-md">
        <h4 class="text-2xl font-bold mb-4 text-center">Volunteer List</h4>
        <?php if (!empty($events)) : ?>
        <form action="authority_volunteer_list.php" method="get">
            <div class="flex items-center mb-4">
                <label for="event_id" class="mr-2">Select Event:</label>
                <select name="event_id" id="event_id" class="border rounded-md p-2">
                    <?php foreach ($events as $event) : ?>
                    <option value="<?php echo $event['event_id']; ?>"
                        <?php echo isset($selectedEventId) && $selectedEventId == $event['event_id'] ? 'selected' : ''; ?>>
                        <?php echo $event['name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-clifford ml-4">view</button>
            </div>
        </form>
        <?php else : ?>
        <p class="text-center text-gray-500">No events hosted by the club.</p>
        <?php endif; ?>

        <?php if (isset($selectedEventId) && !empty($events)) : ?>
        <?php if ($resultVolunteers->num_rows > 0) : ?>
        <form action="" method="post">
            <input type="hidden" name="event_id" value="<?php echo $selectedEventId; ?>">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th class="font-bold text-black" scope=" col">Volunteer ID</th>
                        <th class="font-bold text-black" scope="col">Volunteer Name</th>
                        <th class="font-bold text-black" scope="col">Volunteer Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($volunteer = $resultVolunteers->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $volunteer['student_id']; ?></td>
                        <td><?php echo $volunteer['name']; ?></td>
                        <td><?php echo $volunteer['email']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>
        <?php else : ?>
        <p class="text-center text-gray-500">No volunteers found for the selected event.</p>
        <?php endif; ?>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="authority_event_details.php" class="link link-hover text-blue-500 ">Back to Home</a>
        </div>
    </section>
</body>

</html>