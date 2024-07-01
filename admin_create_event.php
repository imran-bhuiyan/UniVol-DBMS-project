<?php
session_start();

include('config/db_connect.php');
// validating session
 $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }

$name = $description = $req_skill = $date = $deadline= $time = $location = $req_club_id =  $faculty_id = $vol_count = '';
$errors = array(
    'name' => '', 'description' => '', 'date' => '', 'time' => '', 'location' => '',
    'req_skill' => '', 'req_club_id' => '', 'faculty_id' => '', 'vol_count' => '', 'deadline' => ''
);


if (isset($_POST['submit'])) {
  
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description =mysqli_real_escape_string($conn, $_POST['description']);
    $req_skill = mysqli_real_escape_string($conn, $_POST['req_skill']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $req_club_id = mysqli_real_escape_string($conn, $_POST['req_club_id']);
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $vol_count = mysqli_real_escape_string($conn, $_POST['vol_count']);
    $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);

    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Event name is required';
    }

    // Validate description
    if (empty($description)) {
        $errors['description'] = 'Event description is required';
    }

    // Validate date
    if (empty($date)) {
        $errors['date'] = 'Event date is required';
    } elseif (!strtotime($date)) {
        $errors['date'] = 'Invalid date format';
    }elseif (strtotime($date) <= strtotime('tomorrow')) {
    $errors['date'] = 'Event date must be the next day of the current date';
     }

// Validate deadline
   
    if (empty($deadline)) {
        $errors['deadline'] = 'Deadline date is required';
    } 
    // Validate location
    if (empty($location)) {
        $errors['location'] = 'Event location is required';
    }

    // Validate vol_count
    if (empty($vol_count)) {
        $errors['vol_count'] = 'Volunteer count is required';
    } elseif (!ctype_digit($vol_count) || $vol_count <= 0) {
        $errors['vol_count'] = 'Invalid volunteer count';
    }

    // If req_club_id is empty, set it to 0
    if (empty($req_club_id)) {
        $req_club_id = 0;
    }
    else {
    $req_club_id = mysqli_real_escape_string($conn, $req_club_id);
    $club_query = "SELECT * FROM club WHERE id = '$req_club_id'";
    $club_result = mysqli_query($conn, $club_query);

    if (mysqli_num_rows($club_result) == 0) {
        $errors['req_club_id'] = 'Invalid Club ID. Club ID does not exist in database.';
    }
    }

    // If faculty_id is empty, set it to 0
if (empty($faculty_id)) {
    $faculty_id = 0;
} else {
    $faculty_id = mysqli_real_escape_string($conn, $faculty_id);
    $authority_query = "SELECT * FROM authority WHERE id = '$faculty_id'";
    $authority_result = mysqli_query($conn, $authority_query);

    if (mysqli_num_rows($authority_result) == 0) {
        $errors['faculty_id'] = 'Invalid Faculty ID. Faculty ID does not exist in database.';
    }
}

// validate required club

if (empty($req_skill)) {
    $req_skill = 'any';
} 

if ($req_club_id == 0 && $faculty_id == 0) {
    $errors['req_club_id']="Faculty ID and Club ID cannot be 0 at the same time";
}


if(array_filter($errors)){
     	//echo 'errors in the form';
     } else{
    
       
        $name = mysqli_real_escape_string($conn, $name);
        $description = mysqli_real_escape_string($conn, $description);
        $req_skill = mysqli_real_escape_string($conn, $req_skill);
        $date = mysqli_real_escape_string($conn, $date);
        $time = mysqli_real_escape_string($conn, $time);
        $location = mysqli_real_escape_string($conn, $location);
        $req_club_id = mysqli_real_escape_string($conn, $req_club_id);
        $faculty_id = mysqli_real_escape_string($conn, $faculty_id);
        $vol_count = mysqli_real_escape_string($conn, $vol_count);
           $deadline = mysqli_real_escape_string($conn, $deadline);

      
        $sql = "INSERT INTO event_details (name, description, req_skill, date, time, location, req_club_id, faculty_id, vol_count,stat,deadline,remaining_member)
                VALUES ('$name', '$description', '$req_skill', '$date', '$time', '$location', '$req_club_id', '$faculty_id', '$vol_count','approved','$deadline','$vol_count')";

       
        if (mysqli_query($conn, $sql)) {
            // Success
            header('Location: admin_dashboard.php');
            exit(); 
        } else {
            $errors['database'] = 'Query error: ' . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html data-theme="cupcake">

<head>
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

<body class="bg-cupcake">

    <section class="container mx-auto mt-6 text-gray-800">

        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto" action="admin_create_event.php"
            method="POST">
            <h4 class="text-2xl font-bold text-center">Create Event</h4>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Event Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter Event Name"
                    value="<?php echo htmlspecialchars($name) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['name']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description:
                </label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description"
                    placeholder="Enter Event Description"><?php echo htmlspecialchars($description) ?></textarea>
                <div class="text-red-500 italic"> <?php echo $errors['description']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="req_skill">
                    Required Skill:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="req_skill" type="text" name="req_skill" placeholder="Enter Required Skill"
                    value="<?php echo htmlspecialchars($req_skill) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['req_skill']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                    Date:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="date" type="date" name="date" value="<?php echo htmlspecialchars($date) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['date']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="time">
                    Time:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="time" type="time" name="time" value="<?php echo htmlspecialchars($time) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['time']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="location">
                    Location:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="location" type="text" name="location" placeholder="Enter Event Location"
                    value="<?php echo htmlspecialchars($location) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['location']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="req_club_id">
                    Required Club ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="req_club_id" type="text" name="req_club_id" placeholder="Enter Required Club ID"
                    value="<?php echo htmlspecialchars($req_club_id) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['req_club_id']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="faculty_id">
                    Faculty ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="faculty_id" type="text" name="faculty_id" placeholder="Enter Faculty ID"
                    value="<?php echo htmlspecialchars($faculty_id) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['faculty_id']; ?></div>

            </div>

            <!-- deadline handling-->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="deadline">
                    Deadline:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="deadline" type="date" name="deadline" value="<?php echo htmlspecialchars($deadline) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['deadline']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="vol_count">
                    Volunteer Count:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="vol_count" type="number" name="vol_count" placeholder="Enter Volunteer Count"
                    value="<?php echo htmlspecialchars($vol_count) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['vol_count']; ?></div>
            </div>

            <div class="text-center">
                <input type="submit" name="submit" value="Create Event" class="btn btn-primary">
            </div>

            <div class="text-center mt-4">
                <a href="admin_dashboard.php" class="link link-hover text-blue-500 ">Back to Home</a>
            </div>


        </form>



        <?php include ('admin_footer.php'); ?>

    </section>

</body>

</html>