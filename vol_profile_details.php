<?php
session_start();
include('volunteer_header.php');
include("config/db_connect.php");
if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}

function getBadgeId($points) {
    if ($points >= 0 && $points <= 99) {
        return 1;
    } elseif ($points >= 100 && $points <= 199) {
        return 2;
    } elseif ($points >= 200 && $points <= 299) {
        return 3;
    } elseif ($points >= 300 && $points <= 399) {
        return 4;
    } elseif ($points >= 400 && $points <= 499) {
        return 5;
    } elseif ($points >= 500) {
        return 6;
    } else {
        return 6; 
    }
}


$id1 =$_SESSION['vol_id'];

$sql = "SELECT * FROM volunteer WHERE student_id=$id1 ";
$q = mysqli_query($conn, $sql);
$fetch = mysqli_fetch_assoc($q);




$badge_id = getBadgeId($fetch['points']);

// Update badge_id in the database
$updateSql = "UPDATE volunteer SET badge_id = $badge_id WHERE student_id = $id1";
mysqli_query($conn, $updateSql);

$badge_details = "SELECT name from badges where id =$badge_id";
$r = mysqli_query($conn, $badge_details);
$m = mysqli_fetch_assoc($r);





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="styleforprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>


<div class="container mx-auto mt-4 text-center">
    <h2 class="text-2xl font-bold mb-3">My Profile</h2>
</div>

<body class="bg-gray-100">
    <div class="container mx-auto">
        <div class="flex justify-center mt-8">
            <div class="w-full lg:w-2/3 bg-white p-8 rounded-lg shadow-md">
                <div class="text-center mb-4">

                    <p class="text-green-500 text-xl font-semibold">Welcome! <?php echo $fetch['name']; ?></p>
                </div>

                <table class="table w-full">
                    <tr>
                        <th class="w-1/3">Student ID</th>
                        <td><?php echo $fetch['student_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $fetch['name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $fetch['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><?php echo $fetch['phone_num']; ?></td>
                    </tr>
                    <tr>
                        <th>Skill</th>
                        <td><?php echo $fetch['skill']; ?></td>
                    </tr>
                    <tr>
                        <th>Point</th>
                        <td><?php echo $fetch['points']; ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td><?php echo $fetch['dept']; ?></td>
                    </tr>
                    <tr>
                        <th>Warning</th>
                        <td>
                            <?php echo $fetch['penalty_count']; ?>
                            <?php if ($fetch['penalty_count'] > 0) { ?>
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Badge</th>
                        <td class="font-bold">
                            <a href="vol_badge_info.php"><?php echo $m['name']; ?></a>
                        </td>
                    </tr>

                </table>

                <div class="flex justify-center mt-4">

                    <a href="vol_profile_edit.php"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"> Edit Profile </a>

                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

</html>