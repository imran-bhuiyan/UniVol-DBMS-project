<?php
 session_start();
include('config/db_connect.php');
include('volunteer_header.php');
 if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}


    $badge_Query = "SELECT name,description,criteria  FROM badges WHERE id=1";
    $result = mysqli_query($conn, $badge_Query);
    $badge_info = mysqli_fetch_assoc($result);

    $badge_Query1 = "SELECT name,description,criteria  FROM badges WHERE id=2";
    $result1 = mysqli_query($conn, $badge_Query1);
    $badge_info1 = mysqli_fetch_assoc($result1);

    
    $badge_Query2 = "SELECT name,description,criteria  FROM badges WHERE id=3";
    $result2 = mysqli_query($conn, $badge_Query2);
    $badge_info2 = mysqli_fetch_assoc($result2);

    
    $badge_Query3 = "SELECT name,description,criteria  FROM badges WHERE id=4";
    $result3 = mysqli_query($conn, $badge_Query3);
    $badge_info3 = mysqli_fetch_assoc($result3);

        
    $badge_Query4 = "SELECT name,description,criteria  FROM badges WHERE id=5";
    $result4 = mysqli_query($conn, $badge_Query4);
    $badge_info4 = mysqli_fetch_assoc($result4);

        
    $badge_Query5 = "SELECT name,description,criteria  FROM badges WHERE id=6";
    $result5 = mysqli_query($conn, $badge_Query5);
    $badge_info5 = mysqli_fetch_assoc($result5)



?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-4 text-center">
        <h2 class="text-2xl font-bold mb-3">BADGES INFORMATION</h2>
    </div>

    <div class="flex flex-wrap p-4">
        <div class="w-full  p-4">
            <div class="card card-side bg-base-100 shadow-xl card-container relative ">
                <figure class="ml-28">

                    <img src="badge/newbie.png" alt="Event Image">
                </figure>
                <div class="card-body ">

                    <div class="flex">
                        <div class="ml-32">
                            <h1 class="card-title text-blue-500 font-bold"><?php echo $badge_info['name']; ?></h1>
                            <p class="mt-4 italic"><b>Details:</b> <?php echo $badge_info['description']; ?></p>
                            <p class="mt-4 italic"><b>Criteria: </b><?php echo $badge_info['criteria']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap p-4">
        <div class="w-full  p-4">
            <div class="card card-side bg-base-100 shadow-xl card-container relative ">
                <figure class="ml-28">

                    <img src="badge/bronze.png" alt="Event Image">
                </figure>
                <div class="card-body ">

                    <div class="flex">
                        <div class="ml-32">
                            <h1 class="card-title text-blue-500 font-bold"><?php echo $badge_info1['name']; ?></h1>
                            <p class="mt-4 italic"><b>Details:</b> <?php echo $badge_info1['description']; ?></p>
                            <p class="mt-4 italic"><b>Criteria: </b><?php echo $badge_info1['criteria']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap p-4">
        <div class="w-full  p-4">
            <div class="card card-side bg-base-100 shadow-xl card-container relative ">
                <figure class="ml-28">

                    <img src="badge/silver.jpg" alt="Event Image">
                </figure>
                <div class="card-body ">

                    <div class="flex">
                        <div class="ml-32">
                            <h1 class="card-title text-blue-500 font-bold"><?php echo $badge_info2['name']; ?></h1>
                            <p class="mt-4 italic"><b>Details:</b> <?php echo $badge_info2['description']; ?></p>
                            <p class="mt-4 italic"><b>Criteria: </b><?php echo $badge_info2['criteria']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap p-4">
        <div class="w-full  p-4">
            <div class="card card-side bg-base-100 shadow-xl card-container relative ">
                <figure class="ml-28">

                    <img src="badge/gold.jpg" alt="Event Image">
                </figure>
                <div class="card-body ">

                    <div class="flex">
                        <div class="ml-32">
                            <h1 class="card-title text-blue-500 font-bold"><?php echo $badge_info3['name']; ?></h1>
                            <p class="mt-4 italic"><b>Details:</b> <?php echo $badge_info3['description']; ?></p>
                            <p class="mt-4 italic"><b>Criteria: </b><?php echo $badge_info3['criteria']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap p-4">
        <div class="w-full  p-4">
            <div class="card card-side bg-base-100 shadow-xl card-container relative ">
                <figure class="ml-28">

                    <img src="badge/vangurd.png" alt="Event Image">
                </figure>
                <div class="card-body ">

                    <div class="flex">
                        <div class="ml-32">
                            <h1 class="card-title text-blue-500 font-bold"><?php echo $badge_info4['name']; ?></h1>
                            <p class="mt-4 italic"><b>Details:</b> <?php echo $badge_info4['description']; ?></p>
                            <p class="mt-4 italic"><b>Criteria: </b><?php echo $badge_info4['criteria']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap p-4">
        <div class="w-full  p-4">
            <div class="card card-side bg-base-100 shadow-xl card-container relative ">
                <figure class="ml-28">

                    <img src="badge/elite.png" alt="Event Image">
                </figure>
                <div class="card-body ">

                    <div class="flex">
                        <div class="ml-32">
                            <h1 class="card-title text-blue-500 font-bold"><?php echo $badge_info5['name']; ?></h1>
                            <p class="mt-4 italic"><b>Details:</b> <?php echo $badge_info5['description']; ?></p>
                            <p class="mt-4 italic"><b>Criteria: </b><?php echo $badge_info5['criteria']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>