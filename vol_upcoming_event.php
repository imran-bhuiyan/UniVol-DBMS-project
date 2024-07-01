<?php
session_start();

if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}

include('volunteer_header.php');
include('config/db_connect.php');

$vol_id = $_SESSION['vol_id'];
$currentDate = date('Y-m-d');
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "SELECT event_details.*, club.name AS club_name, authority.name AS authority_name 
          FROM event_details
          LEFT JOIN club ON event_details.req_club_id = club.id
          LEFT JOIN authority ON event_details.faculty_id = authority.id
          WHERE event_details.stat = 'approved' AND event_details.deadline >= '$currentDate'";

//  adding anither condition in 1st query 
$query .= " AND (event_details.req_club_id != 0 OR event_details.faculty_id != 0)";

// Add the search condition after 1st query
if (!empty($searchQuery)) {
    $query .= " AND req_skill LIKE '%$searchQuery%'";
}

$query .= " ORDER BY date";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>

    </style>
</head>

<body class="bg-gray-100">

    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="mb-3">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search by skill" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    name="submit">Search</button>
            </div>
        </form>
    </div>

    <div class="flex flex-wrap p-4">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($eventDetails = mysqli_fetch_assoc($result)) {
                echo "<div class='w-full p-2'>";
                echo "<div class='card card-side bg-base-100 shadow-xl card-container relative'>";
                echo "<figure class='ml-28'>";
                echo "<img src='Logo/event_vol.png' alt='Event Image'>";
                echo "</figure>";
                echo "<div class='card-body'>";
                echo "<div class='flex'>";
                echo "<div class='ml-32'>";
                echo "<h1 class='card-title text-blue-500 -mt-2'>Name: " . $eventDetails['name'] . "</h1>";
                echo "<p class='mt-2 font-bold'><b>Organizer: </b>";
                if ($eventDetails['req_club_id'] != 0) {
                    echo $eventDetails['club_name'];
                } elseif ($eventDetails['faculty_id'] != 0) {
                    echo $eventDetails['authority_name'];
                } else {
                    echo "N/A";
                }
                echo "</p>";
                echo "<p class='mt-2 italic'><b>Details: </b>" . $eventDetails['description'] . "</p>";
                echo "<p class='mt-2 italic'><b>Required Skill: </b>" . $eventDetails['req_skill'] . "</p>";
                echo "<p class='mt-2 italic'><b>Required Member: </b>" . $eventDetails['vol_count'] . "</p>";
                echo "<p class='mt-2 italic'><b>Member Left: </b>" . $eventDetails['remaining_member'] . "</p>";
                echo "<p class='mt-2 italic'><b>Date: </b>" . $eventDetails['date'] . "</p>";
                echo "<p class='mt-2 italic'><b>Time: </b>" . $eventDetails['time'] . "</p>";
                echo "<p class='mt-2 italic'><b>Location: </b>" . $eventDetails['location'] . "</p>";
                echo "<p class='mt-2 text-red-500 italic'><b>Registration Deadline: </b>" . $eventDetails['deadline'] . "</p>";
                
                $eventId = $eventDetails['id'];
                $checkRegistrationQuery = "SELECT * FROM vol_participate_event WHERE event_id = $eventId AND student_id = $vol_id";
                $registrationCheckResult = mysqli_query($conn, $checkRegistrationQuery);

                if (mysqli_num_rows($registrationCheckResult) > 0) {
                    echo "<p class='absolute top-0 right-0 p-2 bg-base-100 italic text-green-500'>You are registered</p>";
                } else {
                    echo "<button class='btn btn-primary btn-custom mt-4'>";
                    echo "<a href='vol_reg_event.php?id=" . $eventDetails['id'] . "&student_id=" . $vol_id . "' class='text-white text-decoration-none'>Register</a>";
                    echo "</button>";
                }

                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='p-4 text-red-500'>No events found.</p>";
        }
        ?>
    </div>

</body>

</html>