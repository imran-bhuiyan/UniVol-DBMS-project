<?php 
   
   session_start();
   
   include('config/db_connect.php') ;

   // validating session
    $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }

    
    // volunteerCount

     $queryvol = "SELECT COUNT(student_id) as totalVolunteers FROM volunteer";
     $resultvol = mysqli_query($conn, $queryvol);
     $rowvolunteer = mysqli_fetch_assoc($resultvol);
     $totalVolunteers = $rowvolunteer['totalVolunteers'];


     // clubCount

     $queryclub = "SELECT COUNT(id) as totalClubs FROM club";
     $resultclub = mysqli_query($conn, $queryclub);
     $rowclub = mysqli_fetch_assoc($resultclub);
     $totalClubs = $rowclub['totalClubs'];  

     //event count

     $queryev = "SELECT COUNT(id) as totalEvents FROM event_details";
     $resultev = mysqli_query($conn, $queryev);
     $rowev = mysqli_fetch_assoc($resultev);
     $totalEvents = $rowev['totalEvents'];  


     //total authority
     $queryfac = "SELECT COUNT(id) as totalFac FROM authority";
     $resultfac = mysqli_query($conn, $queryfac);
     $rowfac = mysqli_fetch_assoc($resultfac);
     $totalFac = $rowfac['totalFac'];  


     $totalUser = $totalFac + $totalClubs + $totalVolunteers;




 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
    body {
        background-color: #f0f0f0;
    }

    section {
        margin-top: 2rem;
    }

    .stat-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .stat-card:hover {
        transform: scale(1.05);
    }

    .icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    </style>
</head>

<body>

    <?php include('admin_header.php') ?>

    <section class="container mx-auto mt-16 flex justify-around flex-wrap">

        <div class="stat-card bg-red-500 text-white h-60 w-60 flex flex-col items-center justify-center mb-4">
            <p class="icon"><i class="fa-solid fa-user"></i></p>
            <p class="text-xl font-bold">Users</p>
            <p class="font-bold text-xl"><?php echo $totalUser; ?></p>
        </div>

        <div class="stat-card bg-cyan-500 text-white h-60 w-60 flex flex-col items-center justify-center mb-4">
            <p class="icon"><i class="fa-solid fa-user"></i></p>
            <p class="text-xl font-bold">Total Volunteers</p>
            <p class="font-bold text-xl"><?php echo $totalVolunteers; ?></p>
        </div>

        <div class="stat-card bg-lime-500 text-white h-60 w-60 flex flex-col items-center justify-center mb-4">
            <p class="icon"><i class="fa-solid fa-user"></i></p>
            <p class="text-xl font-bold">Total Clubs</p>
            <p class="font-bold text-xl"><?php echo $totalClubs; ?></p>
        </div>

        <div class="stat-card bg-violet-500 text-white h-60 w-60 flex flex-col items-center justify-center mb-4">
            <p class="icon"><i class="fa-regular fa-calendar-check"></i></p>
            <p class="text-xl font-bold">Total Events</p>
            <p class="font-bold text-xl"><?php echo $totalEvents; ?></p>
        </div>
    </section>

</body>

</html>