<?php

session_start();
 $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }
    
include('config/db_connect.php');

$event_id = '';
$errors = array(
    'name' => '',
    'description' => '',
    'req_skill' => '',
    'date' => '',
    'time' => '',
    'location' => '',
    'req_club_id' => '',
    'faculty_id' => '',
    'vol_count' => ''
);

if (isset($_GET['event_id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['event_id']);

  
    $query = "SELECT * FROM event_details WHERE id = '$event_id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $event = $result->fetch_assoc();

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
           
            $newName = mysqli_real_escape_string($conn, $_POST['name']);
            $newDescription = mysqli_real_escape_string($conn, $_POST['description']);
            $newReqSkill = mysqli_real_escape_string($conn, $_POST['req_skill']);
            $newDate = mysqli_real_escape_string($conn, $_POST['date']);
            $newTime = mysqli_real_escape_string($conn, $_POST['time']);
            $newLocation = mysqli_real_escape_string($conn, $_POST['location']);
            $newReqClubID = mysqli_real_escape_string($conn, $_POST['req_club_id']);
            $newFacultyID = mysqli_real_escape_string($conn, $_POST['faculty_id']);
            $newVolCount = mysqli_real_escape_string($conn, $_POST['vol_count']);

            // Validate the data

            //validate event name
            if (empty($newName)) {
                $errors['name'] = 'Name cannot be empty.';
            }

            //validate event description

            if (empty($newDescription)) {
                $errors['description'] = 'Description cannot be empty';
            }
             
            // handling reqskill field
            
            if (empty($newReqSkill)) {
                $newReqSkill = 'any';
            }

            // Validate date
            if (empty($newDate)) {
                $errors['date'] = 'Event date is required';
            } elseif (!strtotime($newDate)) {
                $errors['date'] = 'Invalid date format';
            } elseif (strtotime($newDate) <= strtotime('tomorrow')) {
                $errors['date'] = 'Event date must be the next day of the current date';
            }

            // Validate location
            if (empty($newLocation)) {
                $errors['location'] = 'Event location is required';
            }

            // Validate vol_count
            if (empty($newVolCount)) {
                $errors['vol_count'] = 'Volunteer count is required';
            } elseif (!ctype_digit($newVolCount) || $newVolCount <= 0) {
                $errors['vol_count'] = 'Invalid volunteer count';
            }

            // If req_club_id is empty, set it to 0
            if (empty($newReqClubID)) {
                $newReqClubID = 0;
            } else {
                $newReqClubID = mysqli_real_escape_string($conn, $newReqClubID);
                $club_query = "SELECT * FROM club WHERE id = '$newReqClubID'";
                $club_result = mysqli_query($conn, $club_query);

                if (mysqli_num_rows($club_result) == 0) {
                    $errors['req_club_id'] = 'Invalid Club ID. Club ID does not exist in the database.';
                }
            }

            // If faculty_id is empty, set it to 0
            if (empty($newFacultyID)) {
                $newFacultyID = 0;
            } else {
                $newFacultyID = mysqli_real_escape_string($conn, $newFacultyID);
                $authority_query = "SELECT * FROM authority WHERE id = '$newFacultyID'";
                $authority_result = mysqli_query($conn, $authority_query);

                if (mysqli_num_rows($authority_result) == 0) {
                    $errors['faculty_id'] = 'Invalid Faculty ID. Faculty ID does not exist in the database.';
                }
            }
            
            // faculty id and req_club id can not be 0 at a time
                  if ($newReqClubID == 0 && $newFacultyID == 0) {
                   $errors['req_club_id']="Faculty ID and Club ID cannot be 0 at the same time";
                           }

            

            if (array_filter($errors)) {
                //echo 'errors in the form';
            } else {
                $updateQuery = "UPDATE event_details SET 
                    name = '$newName', 
                    description = '$newDescription', 
                    req_skill = '$newReqSkill', 
                    date = '$newDate', 
                    time = '$newTime', 
                    location = '$newLocation', 
                    req_club_id = '$newReqClubID', 
                    faculty_id = '$newFacultyID', 
                    vol_count = '$newVolCount'
                    WHERE id = '$event_id'";

                if (mysqli_query($conn, $updateQuery)) {
                   
                    header("Location: admin_manage_event.php");
                    exit();
                } else {
                   
                    header("Location: admin_manage_event.php");
                    exit();
                }
            }
        }
    } else {
       
        header("Location: admin_manage_event.php");
        exit();
    }
}

else {
   
    header("Location: admin_manage_event.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit event</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"
        type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <section class="container mx-auto mt-6 text-gray-800">
        <h4 class="text-2xl font-bold text-center">Edit Event</h4>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
            action="admin_edit_event.php?event_id=<?php echo $event_id; ?>" method="POST">
            <!-- Name Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter Event Name"
                    value="<?php echo htmlspecialchars($event['name']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['name']; ?></div>
            </div>

            <!-- Description Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description:
                </label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="description" name="description"
                    placeholder="Enter Event Description"><?php echo htmlspecialchars($event['description']); ?></textarea>
                <div class="text-red-500 italic"> <?php echo $errors['description']; ?></div>
            </div>

            <!-- Required Skill Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="req_skill">
                    Required Skill:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="req_skill" type="text" name="req_skill" placeholder="Enter Required Skill"
                    value="<?php echo htmlspecialchars($event['req_skill']); ?>">
            </div>

            <!-- Date Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                    Date:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="date" type="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['date']; ?></div>
            </div>

            <!-- Time Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="time">
                    Time:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="time" type="time" name="time" value="<?php echo htmlspecialchars($event['time']); ?>">
            </div>

            <!-- Location Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="location">
                    Location:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="location" type="text" name="location" placeholder="Enter Event Location"
                    value="<?php echo htmlspecialchars($event['location']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['location']; ?></div>
            </div>

            <!-- Required Club ID Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="req_club_id">
                    Required Club ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="req_club_id" type="text" name="req_club_id" placeholder="Enter Required Club ID"
                    value="<?php echo htmlspecialchars($event['req_club_id']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['req_club_id']; ?></div>
            </div>

            <!-- Faculty ID Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="faculty_id">
                    Faculty ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="faculty_id" type="text" name="faculty_id" placeholder="Enter Faculty ID"
                    value="<?php echo htmlspecialchars($event['faculty_id']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['faculty_id']; ?></div>
            </div>

            <!-- Volunteer Count Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="vol_count">
                    Volunteer Count:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="vol_count" type="number" name="vol_count" placeholder="Enter Volunteer Count"
                    value="<?php echo htmlspecialchars($event['vol_count']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['vol_count']; ?></div>
            </div>


            <div class="flex justify-center space-x-4">

                <a href="#" onclick="confirmDelete()"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</a>

                <!-- Update button -->
                <input type="submit" name="submit" value="Update"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </div>
            <div class="text-center mt-4">
                <a href="admin_manage_event.php" class="link link-hover text-blue-500 ">Back to Home</a>
            </div>


        </form>
    </section>

    <script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = 'admin_delete_event.php?event_id=<?php echo $event_id; ?>';
            }
        });
    }
    </script>
</body>


</html>