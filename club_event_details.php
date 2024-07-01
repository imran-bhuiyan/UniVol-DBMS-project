<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: clubLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('club_header.php'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    .card-image {
        height: 150px;
        background-size: cover;
        background-position: center;
    }

    .gradient-bg {
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0) 100%);
    }

    .card-container {
        height: 400px;

    }


    .status-pending {
        color: red;
    }


    .status-done {
        color: green;
    }

    .btn-custom {

        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    </style>
</head>

<body class="bg-gray-100">

    <?php
    include('config/db_connect.php');

    $clubId = $_SESSION['user_id'];
    $currentDate = date('Y-m-d');
    
    $query = "SELECT * FROM event_details WHERE req_club_id = $clubId AND date>='$currentDate' ORDER BY date";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
    ?>
    <div class="flex flex-wrap p-4">
        <?php
            while ($eventDetails = mysqli_fetch_assoc($result)) {
            ?>
        <div class="w-full  p-4">
            <div class="card card-side bg-base-100 shadow-xl card-container relative ">
                <figure class="ml-28">

                    <img src="Logo/event_vol.png" alt="Event Image">
                </figure>
                <div class="card-body ">

                    <div class="flex">
                        <div class="ml-32">
                            <h1 class="card-title text-blue-500 ">Name: <?php echo $eventDetails['name']; ?></h1>
                            <p class="mt-4 italic"><b>ID:</b> <?php echo $eventDetails['id']; ?></p>
                            <p class="mt-4 italic"><b>Details:</b> <?php echo $eventDetails['description']; ?></p>
                            <p class="mt-4 italic"><b>Venue: </b><?php echo $eventDetails['location']; ?></p>
                            <p class="mt-4 italic"><b>Date: </b><?php echo $eventDetails['date']; ?></p>
                            <p class="mt-4 italic"><b>Time: </b><?php echo $eventDetails['time']; ?></p>
                            <p class="mt-4 italic"><b>Required Skill: </b><?php echo $eventDetails['req_skill']; ?></p>
                            <p class="mt-4 italic"><b>Volunteer Count: </b><?php echo $eventDetails['vol_count']; ?></p>
                            <p class="mt-4 italic text-red-500"><b>Registration Deadline:
                                </b><?php echo $eventDetails['deadline']; ?></p>
                        </div>

                    </div>
                    <div
                        class="absolute top-0 right-0 p-2 bg-base-100 italic
                                        <?php echo ($eventDetails['stat'] == "pending") ? 'status-pending' : 'status-done'; ?>">
                        <?php echo $eventDetails['stat']; ?>
                    </div>
                    <!-- <div class="flex  justify-end -mt-40 ">
                        <button class="btn btn-primary btn-custom">cutton</button>
                    </div> -->
                </div>
            </div>
        </div>
        <?php
            }
            ?>
    </div>
    <?php
    } else {
        echo "<p class='p-4 text-red-500'>No Events For Now</p>";
    }
    ?>

</body>

</html>