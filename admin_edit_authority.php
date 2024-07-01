<?php
session_start();
 $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }

include('config/db_connect.php');


$authority_id = '';
$errors = array(
    'name' => '',
    'email' => '',
    'contact_num' => ''
   
    
);

if (isset($_GET['authority_id'])) {
    $authority_id = mysqli_real_escape_string($conn, $_GET['authority_id']);

   
    $query = "SELECT * FROM authority WHERE id = '$authority_id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $authority = $result->fetch_assoc();

       
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
          
            $newName = mysqli_real_escape_string($conn, $_POST['name']);
            $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
            $newContact = mysqli_real_escape_string($conn, $_POST['contact_num']);
            $newType = mysqli_real_escape_string($conn, $_POST['type']);
            

            // Validate the data

            // Check name
    if(empty($newName)){
        $errors['name']= 'A authority name is required <br />';
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

   
    
     if (array_filter($errors)) {
                //echo 'errors in the form';
            } else {
                $updateQuery = "UPDATE authority SET 
                    name = '$newName', 
                    email = '$newEmail', 
                    contact_num = '$newContact', 
                    type = '$newType'
                    WHERE id = '$authority_id'";


                if (mysqli_query($conn, $updateQuery)) {
                    
                    header("Location: admin_manage_authority.php");
                    exit();
                } else {
                    
                    header("Location: admin_manage_authority.php");
                    exit();
                }
            }
        }
    } else {
       
        header("Location: admin_manage_authority.php");
        exit();
    }
} 


else {
   
    header("Location: admin_manage_authority.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit authority</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"
        type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <section class="container mx-auto mt-6 text-gray-800">
        <h4 class="text-2xl font-bold text-center">Edit Authority</h4>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
            action="admin_edit_authority.php?authority_id=<?php echo $authority_id; ?>" method="POST">

            <!-- Name Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter authority Name"
                    value="<?php echo htmlspecialchars($authority['name']); ?>">
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
                    value="<?php echo htmlspecialchars($authority['email']); ?>">
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
                    value="<?php echo htmlspecialchars($authority['contact_num']); ?>">
                <div class="text-red-500 italic"> <?php echo $errors['contact_num']; ?></div>
            </div>

            <!-- Type Select Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                    Type:
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="type" name="type">
                    <option value="Faculty" <?php echo ($authority['type'] == 'Faculty') ? 'selected' : ''; ?>>Faculty
                    </option>
                    <option value="Varsity" <?php echo ($authority['type'] == 'Varsity') ? 'selected' : ''; ?>>Varsity
                    </option>
                </select>
            </div>



            <div class="flex justify-center space-x-4">

                <a href="#" onclick="confirmDelete()"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</a>

                <!-- Update button -->
                <input type="submit" name="submit" value="Update"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </div>
            <div class="text-center mt-4">
                <a href="admin_manage_authority.php" class="link link-hover text-blue-500 ">Back to Home</a>
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

                window.location.href = 'admin_delete_authority.php?authority_id=<?php echo $authority_id; ?>';
            }
        });
    }
    </script>
</body>

</html>