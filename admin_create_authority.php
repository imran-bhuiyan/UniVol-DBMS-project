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


$id = $name = $email = $contact_num = $type = $password = '';

$errors = array('id'=>'','name'=>'','email'=>'','contact_num'=>'','password'=>'');
if(isset($_POST['submit'])){

    // check authority_id

    
if (empty($_POST['id'])) {
    $errors['id'] = 'An id is required <br />';
} elseif (!preg_match('/^\d+$/', $_POST['id'])) {
    $errors['id'] = 'ID should be an integer <br />';
} else {
    $id = $_POST['id'];

    $sql = "SELECT id FROM authority WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $errors['id'] = 'ID already exists <br />';
    }
}


     // Check name
     if(empty($_POST['name'])){
    	$errors['name']= 'A Name is required <br />';
    } else{
    	$name = $_POST['name'];
    	if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
    		$errors['name']= 'Name must be letters and space only';
    	}
    }

    //check email

    if (empty($_POST['email'])) {
    $errors['email'] = 'An email is required<br />';
         } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                 $errors['email'] = 'Email must be a valid email address<br />';
        } else {
        $email = $_POST['email'];
        $sql = "SELECT email FROM authority WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

         if (mysqli_num_rows($result) > 0) {
        $errors['email'] = 'Email is already exist<br />';
    }
}


     //check contact number
     if(empty($_POST['contact_num'])){
    	$errors['contact_num']= 'A contact number is required <br />';
    } else{
    	$contact_num = $_POST['contact_num'];
    	if (!preg_match('/^(?:\+88|01)?\d{11}\r?$/', $contact_num)) {
    		$errors['contact_num']= 'Phone Number Must be a valid number';
    	}
    }

   

    //check password
     if(empty($_POST['password'])){
    	$errors['password']= 'Password can not be empty <br />';
    }



     if(array_filter($errors)){
     	//echo 'errors in the form';
     } else{
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
            $type = mysqli_real_escape_string($conn, $_POST['type']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
   

            // create sql

            $sql= "INSERT INTO authority(id,name,email,contact_num,type,password) VALUES('$id','$name','$email','$contact_num','$type','$password')";

            

            if(mysqli_query($conn, $sql)){
            	// success
            	header('Location: admin_dashboard.php');


            } else{
            	//error
            	echo 'query error: ' . mysqli_error($conn);
            }



     	// echo 'form is valid';
     	
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

<section class="container mx-auto mt-6 text-gray-800">

    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto" action="admin_create_authority.php"
        method="POST">
        <h4 class="text-2xl font-bold text-center">Create Account</h4>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="id">
                ID:
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="id" type="text" name="id" placeholder="Enter ID" value="<?php echo htmlspecialchars($id) ?>">
            <p class="text-red-500 text-xs italic"><?php echo $errors['id']; ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Name:
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="name" type="text" name="name" placeholder="Enter your name"
                value="<?php echo htmlspecialchars($name) ?>">
            <p class="text-red-500 text-xs italic"><?php echo $errors['name']; ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email:
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" type="email" name="email" placeholder="Enter a valid email"
                value="<?php echo htmlspecialchars($email) ?>">
            <p class="text-red-500 text-xs italic"><?php echo $errors['email']; ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="contact_num">
                Contact Number:
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="contact_num" type="text" name="contact_num" placeholder="Enter a Contact Number"
                value="<?php echo htmlspecialchars($contact_num) ?>">
            <p class="text-red-500 text-xs italic"><?php echo $errors['contact_num']; ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                Type:
            </label>
            <select
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="type" name="type">
                <option value="Faculty" <?php echo ($type == 'Faculty') ? 'selected' : ''; ?>>Faculty</option>
                <option value="Varsity" <?php echo ($type == 'Varsity') ? 'selected' : ''; ?>>Varsity</option>
            </select>

        </div>


        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password:
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="password" type="password" name="password" placeholder="Enter a strong password"
                value="<?php echo htmlspecialchars($password) ?>">
            <p class="text-red-500 text-xs italic"><?php echo $errors['password']; ?></p>
        </div>

        <div class="text-center">
            <input type="submit" name="submit" value="Create" class="btn btn-primary">
        </div>
        <div class="text-center mt-4">
            <a href="admin_dashboard.php" class="link link-hover text-blue-500 ">Back to Home</a>
        </div>

    </form>
</section>

<?php include ('admin_footer.php');?>

</html>