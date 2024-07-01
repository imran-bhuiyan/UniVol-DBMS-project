<?php 

include('config/db_connect.php');

$student_id = $name = $email = $phone_num = $skill = $dept = $club = $password  = $ban_status= $ban_end_date = $penalty_count ='';

$errors = array('student_id'=>'','name'=>'','email'=>'','phone_num'=>'','skill'=>'','dept'=>'','club'=>'','password'=>'');
if(isset($_POST['submit'])){

 // check student_id 
	if(empty($_POST['student_id'])){
    	 $errors['student_id']= 'A student id is required <br />';

     } else {
     	$student_id = $_POST['student_id'];
     	$sql = "SELECT student_id FROM volunteer WHERE student_id='$student_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){

            $errors['student_id']= 'Student ID already exist <br />';
        }

     } 

     // Check name
     if(empty($_POST['name'])){
    	$errors['name']= 'A name is required <br />';
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
    $sql = "SELECT email FROM Volunteer WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $errors['email'] = 'Email is already exist<br />';
    }
}


     //check phone number
     if(empty($_POST['phone_num'])){
    	$errors['phone_num']= 'A phone number is required <br />';
    } else{
    	$phone_num = $_POST['phone_num'];
    	if (!preg_match('/^(?:\+88|01)?\d{11}\r?$/', $phone_num)) {
    		$errors['phone_num']= 'Phone Number Must be a valid number';
    	}
    }


   
   // Check skill
    if (empty($_POST['skill'])) {
        $skill = 'any'; // Set $skill 
   } else{
        $skill = $_POST['skill'];
   }

    //check department
     if(empty($_POST['dept'])){
    	$errors['dept']= 'A department is required <br />';
    }

 
    //check password
     if(empty($_POST['password'])){
    	$errors['password']= 'Password can not be empty <br />';
    }



     if(array_filter($errors)){
     	//echo 'errors in the form';
     } else{
            $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
            $skill = mysqli_real_escape_string($conn, $skill);
            $dept = mysqli_real_escape_string($conn, $_POST['dept']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            // create sql

           $sql = "INSERT INTO volunteer (student_id, name, email, phone_num, points, dept, password, badge_id, ban_status, ban_end_date, penalty_count,skill) VALUES ('$student_id', '$name', '$email', '$phone_num', '0', '$dept', '$password', '1', 'Active', '$ban_end_date', '$penalty_count', '$skill')";


            //save into database and check

            if(mysqli_query($conn, $sql)){
            
            	header('Location: volunteerLogin.php');


            } else{
            
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

    <div>

        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto" action="volunteerSignup.php"
            method="POST">
            <h4 class="text-2xl font-bold text-center">Signup</h4>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="student_id">
                    Student ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="student_id" type="text" name="student_id" placeholder="Enter your Student ID"
                    value="<?php echo htmlspecialchars($student_id) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['student_id']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter your name"
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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_num">
                    Phone Number:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="phone_num" type="text" name="phone_num" placeholder="Enter your Mobile Number"
                    value="<?php echo htmlspecialchars($phone_num) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['phone_num']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="skill">
                    Skill:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="skill" type="text" name="skill" placeholder="Enter your skills separated with comma"
                    value="<?php echo htmlspecialchars($skill) ?>">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="dept">
                    Dept:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="dept" type="text" name="dept" placeholder="Enter your department name"
                    value="<?php echo htmlspecialchars($dept) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['dept']; ?></div>
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