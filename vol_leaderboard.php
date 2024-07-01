<?php

session_start();
if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}


include('config/db_connect.php');
include('volunteer_header.php');


$order = "DESC";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set the order 
    $order = $_POST['order'] === 'asc' ? 'ASC' : 'DESC';

    // Modify the SQL query based on the selected filter
    if ($_POST['order'] === 'events') {
        $sql = "SELECT volunteer.student_id, volunteer.name, volunteer.email, volunteer.points, COUNT(vol_participate_event.event_id) AS events_count
                FROM volunteer
                LEFT JOIN vol_participate_event ON volunteer.student_id = vol_participate_event.student_id
                GROUP BY volunteer.student_id
                ORDER BY events_count $order";
    } else {
        $sql = "SELECT volunteer.student_id, volunteer.name, volunteer.email, volunteer.points, COUNT(vol_participate_event.event_id) AS events_count
                FROM volunteer
                LEFT JOIN vol_participate_event ON volunteer.student_id = vol_participate_event.student_id
                GROUP BY volunteer.student_id
                ORDER BY points $order";
    }

  
    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 p-8">

    <div class="mb-4 text-center mt-4">
        <h1 class="text-4xl font-bold">Leaderboard</h1>
        <i class="fa-solid fa-trophy"></i>

    </div>


    <div class="mb-4">
        <form method="post">
            <label for="filter" class="mr-2">Filter By:</label>
            <select name="order" id="filter" class="p-2 border rounded">
                <option value="asc" <?php echo ($order === 'ASC') ? 'selected' : ''; ?>>Ascending Order</option>
                <option value="desc" <?php echo ($order === 'DESC') ? 'selected' : ''; ?>>Descending Order</option>
                <option value="events" <?php echo ($order === 'events') ? 'selected' : ''; ?>>Events Participated
                </option>
            </select>
            <button type="submit" class="ml-2 p-2 bg-blue-500 text-white rounded">Apply</button>
        </form>
    </div>

    <!-- Leaderboard Table -->
    <div>
        <table class="w-full border-collapse border justify-normal">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">SL</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Points</th>
                    <th class="border p-2">Events</th>
                </tr>
            </thead>
            <tbody id="leaderboardBody">
                <?php
                if (isset($result) && $result->num_rows > 0) {
                    $rank = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border p-2'>" . $rank . "</td>";
                        echo "<td class='border p-2'>" . $row['name'] . "</td>";
                        echo "<td class='border p-2'>" . $row['email'] . "</td>";
                        echo "<td class='border p-2'>" . $row['points'] . "</td>";
                        echo "<td class='border p-2'>" . ($row['events_count'] ?? 0) . "</td>";
                        echo "</tr>";
                        $rank++;
                    }
                } else {
                    echo "<tr>";
                    echo "<td class='border p-2' colspan='5'>No volunteers found.</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="leaderboard.js"></script>
</body>

</html>