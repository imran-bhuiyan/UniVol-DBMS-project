<?php
session_start();

if (!isset($_SESSION['vol_id'])) {
    header("Location: volunteerlogin.php");
    exit();
}

include('config/db_connect.php');
$vol_id = $_SESSION['vol_id'];

$query = "SELECT vpe.reg_Date as date, ed.name as name, ed.id as event_id,ed.date as event_date
        FROM vol_participate_event vpe 
        JOIN event_details ed ON vpe.event_id = ed.id
        WHERE vpe.student_id = $vol_id
        ORDER BY vpe.Reg_Date DESC";


$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('volunteer_header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Volunteer Registration History</title>
</head>

<body class="bg-gray-100">
    <section class="container mx-auto my-8 p-8 bg-white shadow-md rounded-md">
        <h4 class="text-2xl font-bold mb-4 text-center">Volunteer Registration History</h4>

        <?php if ($result->num_rows > 0) : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Event ID</th>
                    <th scope="col">Event Name</th>
                    <th scope="col">Date & Time</th>
                    <th scope="col">Progress</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['event_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td
                        class="<?php echo (strtotime($row['event_date']) < strtotime(date('Y-m-d H:i:s'))) ? 'text-green-500' : 'text-red-500'; ?>">
                        <?php echo (strtotime($row['event_date']) < strtotime(date('Y-m-d H:i:s'))) ? 'Completed' : 'Pending'; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else : ?>
        <p class="text-center text-gray-500">No events in history.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="vol_upcoming_event.php" class="link link-hover text-blue-500">Back to Home</a>
        </div>
    </section>
</body>

</html>