<?php
session_start();
 $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }

include('config/db_connect.php');

$club_id = '';
$errors = array(
    'name' => '',
    'email' => '',
    'contact_num' => '',
    'president_name' => ''
    
);

if (isset($_GET['club_id'])) {
    $club_id = mysqli_real_escape_string($conn, $_GET['club_id']);

   
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
    
     if (array_filter($errors)) {
                //echo 'errors in the form';
            } else {
                $updateQuery = "UPDATE club SET 
                    name = '$newName', 
                    email = '$newEmail', 
                    contact_num = '$newContact', 
                    president_name = '$newPresident' 
                    WHERE id = '$club_id'";


                if (mysqli_query($conn, $updateQuery)) {
                   
                    header("Location: admin_manage_club.php");
                    exit();
                } else {
                   
                    header("Location: admin_manage_club.php");
                    exit();
                }
            }
        }
    } else {
        
        header("Location: admin_manage_club.php");
        exit();
    }
} 


else {
   
    header("Location: admin_manage_club.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit club</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"
        type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <section class="container mx-auto mt-6 text-gray-800">
        <h4 class="text-2xl font-bold text-center">Edit club</h4>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
            action="admin_edit_club.php?club_id=<?php echo $club_id; ?>" method="POST">
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




            <div class="flex justify-center space-x-4">

                <a href="#" onclick="confirmDelete()"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</a>

                <!-- Update button -->
                <input type="submit" name="submit" value="Update"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </div>
            <div class="text-center mt-4">
                <a href="admin_manage_club.php" class="link link-hover text-blue-500 ">Back to Home</a>
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

                window.location.href = 'admin_delete_club.php?club_id=<?php echo $club_id; ?>';
            }
        });
    }
    </script>
</body>

</html>