<?php 
session_start();
include('config/db_connect.php');

$student_id = $password = '';
 $loginError='';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  input
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    // Sanitize for SQL injection
    $student_id = mysqli_real_escape_string($conn, $student_id);
    $password = mysqli_real_escape_string($conn, $password);

    // validation
    $query = "SELECT * FROM volunteer WHERE student_id = '$student_id' AND password = '$password'";
    $result = $conn->query($query);

   if ($result->num_rows == 1) {
        // Check ban status and ban end date
        $user = $result->fetch_assoc();
        if ($user['ban_status'] == 'Banned') {
            $currentDate = date('Y-m-d H:i:s');
            $banEndDate = $user['ban_end_date'];

            if ($currentDate < $banEndDate) {
                $loginError = "Account is banned. Please try again after " . date('F j, Y, g:i a', strtotime($banEndDate));
            } else {
                // Ban period has ended, now  allow login
                $_SESSION['vol_id'] = $user['student_id'];
                header("Location: vol_upcoming_event.php");
                exit();
            }
        } else {
            
            $_SESSION['vol_id'] = $user['student_id'];
            header("Location: vol_upcoming_event.php");
            exit();
        }
    } else {
       
        $loginError = "Invalid Student ID or Password. Please try again";
    }
}



?>


<!DOCTYPE html>
<html data-theme="cupcake">
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
<style>
body {

    background-color: #3498db;



    background: linear-gradient(to right, #3498db, #2c3e50);


    background-size: cover;

    background-position: center;

    background-repeat: no-repeat;
}
</style>

<body>
    <div class="hero min-h-screen ">
        <div class="hero-content flex-col">

            <div class="card shrink-0 w-screen max-w-sm shadow-2xl bg-base-100 ">
                <form class="bg-white  px-8 pt-6 pb-8 mb-4 w-full rounded-t-xl" action="volunteerLogin.php"
                    method="POST">

                    <h1 class="text-5xl font-bold text-black text-center mb-6">Login</h1>


                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="student_id">
                            Student ID:
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="student_id" type="text" name="student_id" placeholder="Enter Student ID">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password:
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" type="password" name="password" placeholder="Enter your password">
                    </div>

                    <div class="text-center">
                        <input type="submit" name="submit" value="Login" class="btn btn-primary">
                    </div>


                    <?php if (!empty($loginError)) : ?>
                    <div class="text-center mt-4 text-red-500">
                        <?php echo $loginError; ?>
                    </div>
                    <?php endif; ?>

                    <div class="text-center mt-4">
                        <p>New to UniVol? <a href="volunteerSignup.php"
                                class="link link-hover text-blue-500"><b>Signup</b></a>
                        </p>
                    </div>
                    <div class="text-center mt-4">
                        <a href="index.php" class="link link-hover text-blue-500 ">Back to Home</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>


</html>