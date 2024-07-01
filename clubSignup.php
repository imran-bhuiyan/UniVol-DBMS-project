<?php

include('config/db_connect.php');

$id = $name = $email = $contact_num = $president_name = $password = '';

$errors = array('id'=>'','name'=>'','email'=>'','contact_num'=>'','president_name'=>'','password'=>'');
if(isset($_POST['submit'])){

    // Check id
    if(empty($_POST['id'])){
        $errors['id']= 'A Club id is required <br />';
    } else {
        $id = $_POST['id'];
        $sql = "SELECT id FROM club WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){
            $errors['id']= 'Club ID already exists <br />';
        }
    }

    // Check name
    if(empty($_POST['name'])){
        $errors['name']= 'A club name is required <br />';
    } else{
        $name = $_POST['name'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $errors['name']= 'Name must be letters and space only';
        }
    }

    // Check email
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required<br />';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email must be a valid email address<br />';
    } else {
        $email = $_POST['email'];
        $sql = "SELECT email FROM club WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = 'Email is already exist<br />';
        }
    }

    // Check contact number
    if(empty($_POST['contact_num'])){
        $errors['contact_num']= 'A phone number is required <br />';
    } 

   
    // Check president name
    if(empty($_POST['president_name'])){
        $errors['president_name']= 'A president_name is required <br />';
    } else{
        $president_name = $_POST['president_name'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $president_name)) {
            $errors['president_name']= 'Name must be letters and space only';
        }
    }

    // Check password
    if(empty($_POST['password'])){
        $errors['password']= 'Password can not be empty <br />';
    }

    if(array_filter($errors)){
        // echo 'errors in the form';
    } else {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $contact_num = mysqli_real_escape_string($conn, $_POST['contact_num']);
        $president_name = mysqli_real_escape_string($conn, $_POST['president_name']);
        
        $password = mysqli_real_escape_string($conn, $_POST['password']);

       
        $sql= "INSERT INTO club(id,name,email,contact_num,president_name,password) VALUES('$id','$name','$email','$contact_num','$president_name','$password')";

     
        if(mysqli_query($conn, $sql)){
           
            header('Location: clubLogin.php');
        } else{
            
            echo 'query error: ' . mysqli_error($conn);
        }
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
    <div>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto" action="clubSignup.php"
            method="POST">
            <h4 class="text-2xl font-bold text-center">Signup</h4>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="id">
                    Club ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="id" type="text" name="id" placeholder="Enter Club ID"
                    value="<?php echo htmlspecialchars($id) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['id']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Club Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter club name"
                    value="<?php echo htmlspecialchars($name) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['name']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="email" name="email" placeholder="Enter a valid email"
                    value="<?php echo htmlspecialchars($email) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['email']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contact_num">
                    Contact Number:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="contact_num" type="text" name="contact_num" placeholder="Enter club's contact Number"
                    value="<?php echo htmlspecialchars($contact_num) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['contact_num']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="president_name">
                    President Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="president_name" type="text" name="president_name" placeholder="Enter club's president name "
                    value="<?php echo htmlspecialchars($president_name) ?>">
            </div>


            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" name="password" placeholder="Enter a strong password"
                    value="<?php echo htmlspecialchars($password) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['password']; ?></div>
            </div>

            <div class="text-center">
                <input type="submit" name="submit" value="Signup" class="btn btn-primary">
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="link link-hover text-blue-500 ">Back to Home</a>
            </div>

        </form>
    </div>




</section>

</html>