<?php
session_start();
include('config/db_connect.php');
if (isset($_SESSION['vol_id'])) {
  
    $vol_id = $_SESSION['vol_id'];

    
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}



if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the current password
    $query = "SELECT password FROM volunteer WHERE student_id = '$vol_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        if ($current_password == $stored_password) {
            if ($new_password == $confirm_password) {
                // Update the password 
                $query_update = "UPDATE volunteer SET password = '$new_password' WHERE student_id = '$vol_id'";
                $result_update = mysqli_query($conn, $query_update);

                if ($result_update) {
                    // success message
                    $success_message = 'Password changed successfully!';
                    header("Location: volunteerLogin.php");
                    exit();
                } else {
                    $error_message = 'Error updating password. Please try again.';
                }
            } else {
                $error_message = 'New password and confirm password do not match';
            }
        } else {
            $error_message = 'Current password does not match';
        }
    } else {
        $error_message = 'Error fetching data from the database. Please try again.';
    }
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.7/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    clifford: '#da373d',
                }
            }
        }
    }
    </script>
</head>

<body>

    <?php include('volunteer_header.php'); ?>

    <section class="container mx-auto mt-8 mb-1 text-gray-800">
        <div>
            <?php
            if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            } elseif (isset($success_message)) {
                echo "<p style='color: green;'>$success_message</p>";
            }
            ?>


            <form class=" bg-white shadow-md rounded px-16 pt-6 pb-8 mb-4 w-1/2 mx-auto" action="vol_pass_change.php"
                method="POST">
                <h1 class="font-bold text-center mb-8">Change Password</h1>
                <div class="flex">
                    <div class="form-group flex flex-col gap-7">
                        <label for="current_password">Current Password:</label>
                        <label for="new_password">New Password:</label>
                        <label for="confirm_password">Confirm Password:</label>
                    </div>

                    <div class="form-group flex flex-col gap-4 ">
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="password" name="current_password" required>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="password" name="new_password" required>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="password" name="confirm_password" required>
                    </div>
                </div>


                <button type="submit" class="btn btn-outline btn-primary mt-4" name="change_password">Change
                    Password</button>
            </form>

</body>

</html>