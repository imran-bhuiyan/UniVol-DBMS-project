<?php
session_start();
include('config/db_connect.php');


$admin_dash = $_SESSION['admin_name'];
if (!$admin_dash) {
    header("Location: adminLogin.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $queryId = $_POST['id'];

   
    $updateQuery = "UPDATE query SET action = 'done' WHERE id = $queryId";
    $conn->query($updateQuery);

    
    header("Location: admin_queries.php");
    exit();
}


$query = "SELECT id, name, email, subject, details, post_date, action FROM query WHERE action = 'pending'";
$result = $conn->query($query);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <?php include('admin_header.php') ?>
</head>

<body>

    <section>
        <div class="overflow-x-auto">
            <form method="POST" action="admin_queries.php">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SL#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Details</th>
                            <th>Post Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['subject'] . "</td>";
                                echo "<td>" . $row['details'] . "</td>";
                                echo "<td>" . $row['post_date'] . "</td>";
                                echo '<td>';
                                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="btn btn-outline btn-primary">Mark as Done</button>';
                                echo '</td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No pending queries found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </section>



</body>

</html>