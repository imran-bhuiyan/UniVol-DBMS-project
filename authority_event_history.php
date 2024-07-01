<?php
session_start();

if (!isset($_SESSION['autho_id'])) {
    header("Location: authoritylogin.php");
    exit();
}

include('config/db_connect.php');
$autho_id = $_SESSION['autho_id'];

$query = "SELECT ahe.event_id, ed.name AS event_name, ed.date
FROM authority_host_event ahe
INNER JOIN event_details ed ON ahe.event_id = ed.id
WHERE ahe.authority_id = '$autho_id'";

$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('authority_header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Authority Event History</title>
</head>

<body class="bg-gray-100">
    <section class="container mx-auto my-8 p-8 bg-white shadow-md rounded-md">
        <h4 class="text-2xl font-bold mb-4 text-center">Authority Event History</h4>

        <?php if ($result->num_rows > 0) : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Event ID</th>
                    <th scope="col">Event Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Progress</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['event_id']; ?></td>
                    <td><?php echo $row['event_name']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td
                        class="<?php echo (strtotime($row['date']) < strtotime(date('Y-m-d'))) ? 'text-green-500 italic' : 'text-red-500 italic'; ?>">
                        <?php echo (strtotime($row['date']) < strtotime(date('Y-m-d'))) ? 'Completed' : 'Pending'; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else : ?>
        <p class="text-center text-gray-500">No events in the history.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="authority_event_details.php" class="link link-hover text-blue-500">Back to Home</a>
        </div>
    </section>
</body>

</html>