<?php
session_start();
include('config/db_connect.php');


$admin_dash = $_SESSION['admin_name'];
if (!$admin_dash) {
    header("Location: adminLogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['updateStatus'])) {
    $complaintId = $_POST['id'];
    $newStatus = $_POST['updateStatus'];

    $updateQuery = "UPDATE complain SET progress = '$newStatus' WHERE id = $complaintId";
    $conn->query($updateQuery);

    // Check the selected penalty option
    $selectedPenalty = $_POST['penalty'];

    // Get the details of the complaint
    $complaintDetailsQuery = "SELECT vol_id, vol_name FROM complain WHERE id = $complaintId";
    $complaintDetailsResult = $conn->query($complaintDetailsQuery);

    if ($complaintDetailsResult->num_rows > 0) {
        $row = $complaintDetailsResult->fetch_assoc();

      
        $volunteerId = $row['vol_id'];

        // Handle different penalty options
        switch ($selectedPenalty) {
            case 'Deduct5Points':
                // Deduct 5 points
                $updateVolunteerQuery = "UPDATE volunteer SET points = points - 5, penalty_count = penalty_count + 1 WHERE student_id = $volunteerId";
                $conn->query($updateVolunteerQuery);
                break;
            case 'Ban3Days':
                // Ban for 3 daysand deduct 10 points
                $banEndDate = date('Y-m-d H:i:s', strtotime('+3 days'));
                $updateVolunteerQuery = "UPDATE volunteer SET ban_status = 'Banned', ban_end_date = '$banEndDate', penalty_count = penalty_count + 1 , points= points-10 WHERE student_id = $volunteerId";
                $conn->query($updateVolunteerQuery);
                break;
            case 'Ban7Days':
                // Ban for 7 days and deduct 25 points
                $banEndDate = date('Y-m-d H:i:s', strtotime('+7 days'));
                $updateVolunteerQuery = "UPDATE volunteer SET ban_status = 'Banned', ban_end_date = '$banEndDate', penalty_count = penalty_count + 1 , points= points-25 WHERE student_id = $volunteerId";
                $conn->query($updateVolunteerQuery);
                break;
            case 'PermanentBan':
                // Permanent Ban and deduct 50 points
                 $banEndDate = date('Y-m-d H:i:s', strtotime('+18250 days'));
                $updateVolunteerQuery = "UPDATE volunteer SET ban_status = 'Banned',  ban_end_date = '$banEndDate', penalty_count = penalty_count + 1, points= points-50 WHERE student_id = $volunteerId";
                $conn->query($updateVolunteerQuery);
                break;
            default:
              
                break;
        }
    }

   
    header("Location: admin_issues.php");
    exit();
}


$query = "SELECT id, vol_id, vol_name, event_id, details, progress FROM complain WHERE progress = 'Pending'";
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
            <form method="POST" action="admin_issues.php">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SL#</th>
                            <th>Volunteer ID</th>
                            <th>Volunteer Name</th>
                            <th>Event ID</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Penalty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
// Display complaints with status "Pending" in the table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><a href='admin_edit_vol.php?student_id=" . $row['vol_id'] . "' class='text-blue-600 dark:text-blue-500 hover:underline'>" . $row['vol_id'] . "</a></td>";
        
        echo "<td>" . $row['vol_name'] . "</td>";
        echo "<td>" . $row['event_id'] . "</td>";
        echo "<td>" . $row['details'] . "</td>";
        echo "<td>" . $row['progress'] . "</td>";
        echo '<td>';
        echo '<form method="POST" action="admin_issues.php">';
        echo '<select name="penalty" class="form-control">';
        echo '<option value="Select" selected>Select</option>';
        echo '<option value="Deduct5Points">Deduct 5 points</option>';
        echo '<option value="Ban3Days">Ban for 3 days</option>';
        echo '<option value="Ban7Days">Ban for 7 days</option>';
        echo '<option value="PermanentBan">Permanent Ban</option>';
        echo '</select>';
        echo '</td>';
        echo '<td>';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<button type="submit" class="btn btn-outline btn-primary" name="updateStatus" value="Completed">Mark as Completed</button>';
        echo '</form>';
        echo '</td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No pending complaints found.</td></tr>";
}
?>

                    </tbody>
                </table>
            </form>
        </div>
    </section>

    <?php include('admin_footer.php') ?>

</body>

</html>