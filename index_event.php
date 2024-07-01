<?php
include('config/db_connect.php');
include('templates/header.php');

$currentDate = date('Y-m-d');
$query = "SELECT * FROM event_details WHERE date >= '$currentDate' AND stat = 'approved' ORDER BY date";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Title Here</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Grid of Cards -->
    <div class="container mx-auto mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
           
        ?>

        <div class="bg-white overflow-hidden shadow-md rounded-lg">
            <img class="w-full h-48 object-cover" src="logo/my_event.jpg" alt="Movie">
            <div class="p-6">
                <h1 class="text-2xl font-semibold mb-3"><?php echo $row['name']; ?></h1>
                <p class="text-black-600 italic"><?php echo date('d F, Y', strtotime($row['date'])); ?></p>

                <p class="text-gray-600 italic"><?php echo $row['description']; ?></p>

                <div class="mt-4">
                    <a href="volunteerLogin.php" class="px-4 py-2 bg-blue-500 text-white rounded">Register</a>
                </div>
            </div>
        </div>

        <?php
        }
        ?>

    </div>

</body>

</html>