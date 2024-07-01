<?php
session_start();

include('config/db_connect.php');

$club_id = '';
$errors = array(
    'name' => '',
    'email' => '',
    'contact_num' => '',
    'president_name' => ''
);


if (!isset($_SESSION['user_id'])) {
   
    header("Location: clubLogin.php");
    exit();
}


$club_id = $_SESSION['user_id'];


$query = "SELECT * FROM club WHERE id = '$club_id'";
$result = $conn->query($query);


if ($result->num_rows == 1) {
    $club = $result->fetch_assoc();

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
       
        $newName = mysqli_real_escape_string($conn, $_POST['name']);
        $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
        $newContact = mysqli_real_escape_string($conn, $_POST['contact_num']);
        $newPresident = mysqli_real_escape_string($conn, $_POST['president_name']);

        // Validate the data

        // Check name
        if(empty($newName)){
            $errors['name']= 'A club name is required <br />';
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
            $errors['contact_num']= 'A phone number is required <br />';
        } 

        // Check president name
        if(empty($newPresident)){
            $errors['president_name']= 'A president_name is required <br />';
        } else{
            if (!preg_match('/^[a-zA-Z\s]+$/', $newPresident)) {
                $errors['president_name']= 'Name must be letters and space only';
            }
        }

        // If there are no errors, update the database
        if (empty(array_filter($errors))) {
            $updateQuery = "UPDATE club SET 
                name = '$newName', 
                email = '$newEmail', 
                contact_num = '$newContact', 
                president_name = '$newPresident' 
                WHERE id = '$club_id'";

            if (mysqli_query($conn, $updateQuery)) {
               
                header("Location: club_event_details.php");
                exit();
            } else {
                
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    }
} else {
    
    header("Location: club_event_details.php");
    exit();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('club_header.php'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit club</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"
        type="text/css" />
</head>

<body>
    <section class="container mx-auto mt-6 text-gray-800">

        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto" action="club_edit_profile.php"
            method="POST">
            <h4 class="text-2xl font-bold text-center"><b>Edit Profile</b></h4>
            <!-- Name Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter club Name"
                    value="<?php echo htmlspecialchars($club['name']); ?>">
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
                    value="<?php echo htmlspecialchars($club['email']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['email']; ?></div>
            </div>

            <!-- Contact Number Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contact_num">
                    Contact Number:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="contact_num" type="tel" name="contact_num" placeholder="Enter a contact number"
                    value="<?php echo htmlspecialchars($club['contact_num']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['contact_num']; ?></div>
            </div>

            <!-- President Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="president_name">
                    President's Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="president_name" type="text" name="president_name" placeholder="Enter president's name"
                    value="<?php echo htmlspecialchars($club['president_name']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['president_name']; ?></div>
            </div>

            <!-- Hidden input for club_id from session -->
            <input type="hidden" name="club_id" value="<?php echo $club_id; ?>">

            <!-- Update button -->
            <div class="flex justify-center">
                <input type="submit" name="submit" value="Update"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </div>
            <div class="text-center mt-4">
                <a href="club_event_details.php" class="link link-hover text-blue-500 ">Back to Home</a>
            </div>


        </form>
    </section>
</body>

</html>