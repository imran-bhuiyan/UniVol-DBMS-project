<?php
session_start();

include('config/db_connect.php');


if (!isset($_SESSION['vol_id'])) {
    
    header("Location: volunteerLogin.php");
    exit();
}

// Get volunteer_id from session
$vol_id = $_SESSION['vol_id'];
$errors = array(
    'name' => '',
    'email' => '',
    'phone_num' => '',
    'skill' => ''
);


$query = "SELECT * FROM volunteer WHERE student_id = '$vol_id'";
$result = $conn->query($query);


if ($result->num_rows == 1) {
    $volunteer = $result->fetch_assoc();

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // Get updated volunteer data
        $newName = mysqli_real_escape_string($conn, $_POST['name']);
        $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
        $newContact = mysqli_real_escape_string($conn, $_POST['phone_num']);
        $newSkill = mysqli_real_escape_string($conn, $_POST['skill']);

        // Validate the data

        // Check name
        if(empty($newName)){
            $errors['name']= 'A volunteer name is required <br />';
        } else{
            if (!preg_match('/^[a-zA-Z\s]+$/', $newName)) {
                $errors['name']= 'Name must be letters and space only';
            }
        }

        // Check email
        if (empty($newEmail)) {
            $errors['email'] = 'An email is required<br />';
        } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL))  {
            $errors['email'] = 'Email must be a valid email address<br />';
        } 

        // Check contact number
        if(empty($newContact)){
            $errors['phone_num']= 'A phone number is required <br />';
        } 

        // Check skill 
        if(empty($newSkill)){
           $newSkill = 'any';
        } 
        // errors, update database
        if (empty(array_filter($errors))) {
            $updateQuery = "UPDATE volunteer SET 
                name = '$newName', 
                email = '$newEmail', 
                phone_num = '$newContact', 
                skill = '$newSkill' 
                WHERE student_id = '$vol_id'";

            if (mysqli_query($conn, $updateQuery)) {
               
                header("Location: vol_profile_details.php");
                exit();
            } else {
                
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    }
} else {
  
    header("Location: volunteer_event_details.php");
    exit();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('volunteer_header.php'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit volunteer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"
        type="text/css" />
</head>

<body>
    <section class="container mx-auto mt-6 text-gray-800">

        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto" action="vol_profile_edit.php"
            method="POST">
            <h4 class="text-2xl font-bold text-center"><b>Edit Profile</b></h4>
            <!-- Name Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter volunteer Name"
                    value="<?php echo htmlspecialchars($volunteer['name']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['name']; ?></div>
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="email" name="email" placeholder="Enter a valid email"
                    value="<?php echo htmlspecialchars($volunteer['email']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['email']; ?></div>
            </div>

            <!-- Contact Number Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_num">
                    Contact Number:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="phone_num" type="tel" name="phone_num" placeholder="Enter a contact number"
                    value="<?php echo htmlspecialchars($volunteer['phone_num']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['phone_num']; ?></div>
            </div>

            <!-- Skill Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="skill">
                    Skill:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="skill" type="text" name="skill" placeholder="Enter skill"
                    value="<?php echo htmlspecialchars($volunteer['skill']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['skill']; ?></div>
            </div>



            <!-- Update button -->
            <div class="flex justify-center">
                <input type="submit" name="submit" value="Update"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </div>
            <div class="text-center mt-4">
                <a href="vol_upcoming_event.php" class="link link-hover text-blue-500 ">Back to Home</a>
            </div>


        </form>
    </section>
</body>

</html>