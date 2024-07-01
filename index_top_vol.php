<?php
include('config/db_connect.php');


$sql = "SELECT name, dept, points FROM volunteer ORDER BY points DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result) {
   
    $volunteerData = mysqli_fetch_assoc($result);
} else {
    
    echo 'Error: ' . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.7/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<?php include('templates/header.php'); ?>

<body>

    <!-- Profile Section -->
    <div class="flex items-center justify-center mt-8 flex-col ">
        <!-- Profile Photo Box -->
        <div class="rounded-full overflow-hidden bg-gray-200 w-96 h-96 flex-shrink-0 mb-24">
            <img src="logo/profile1.png" alt="Profile Photo" class="w-full h-full object-cover">
        </div>

        <!-- Details Box -->
        <div class="text-center -mt-8">
            <h2 class="text-2xl font-bold text-gray-800"><?php echo $volunteerData['name']; ?></h2>
            <p class="text-gray-600">Department: <?php echo $volunteerData['dept']; ?></p>
            <p class="text-gray-600">Points: <?php echo $volunteerData['points']; ?></p>
        </div>
    </div>



</body>




</html>