<?php 

include('config/db_connect.php');
$name = $email = $subject= $details = '';
if(isset($_POST['submit'])){
    
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $details = mysqli_real_escape_string($conn, $_POST['message']);
        
        
          // Create SQL
        $sql= "INSERT INTO query(name,email,subject,details,action) VALUES('$name','$email','$subject','$details','pending')";

       
        if(mysqli_query($conn, $sql)){
          
            header('Location: index_contact_us.php');
        } else{
            
            echo 'query error: ' . mysqli_error($conn);
        }
    }
$query1 = "SELECT* FROM pages WHERE id = 2";
$query2 = "SELECT* FROM pages WHERE id = 3";

$result1 = $conn->query($query1);
$result2 = $conn->query($query2);

$row1 = $result1->fetch_assoc();
$row2 = $result2->fetch_assoc();

$content1 = $row1['description'];
$content2 = $row2['description'];



 ?>


<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.7/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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


<?php include ('templates/header.php'); ?>




<section>
    <div class="hero min-h-[30vh]" style="background-image: url(logo/contact.jpg);">
        <div class="hero-overlay bg-opacity-60 "></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h2 class="mb-5 text-5xl font-bold text-white  whitespace-nowrap">CONTACT US</h2>

                <p class="mb-5 text-white">Get in touch</p>
            </div>
        </div>
    </div>
</section>

<section class="flex">
    <div class="flex-1">
        <div class="flex flex-col ml-36 p-24 ">
            <div class="flex item-center justify-center">
                <div><i class="fa-solid fa-envelope mr-4 text-4xl"></i></div>
                <div>
                    <p class="text-4xl font-semi-bold text-black mb-4">Email Us</p>
                    <p class="font-bold"><?php echo $content1; ?></p>
                </div>
            </div>
            <div class="flex item-center justify-center mt-10 mb-10">
                <div><i class="fa-solid fa-phone-volume mr-4 text-4xl"></i></div>
                <div>
                    <p class="text-4xl font-semi-bold text-black mb-4">Call Us</p>
                    <p class="font-bold"><?php echo $content2; ?></p>
                </div>
            </div>
            <div class="flex item-center justify-center">

                <div class="text-4xl text-center">
                    <p class="text-4xl font-semi-bold text-black">Social Media</p>

                    <a href="https://www.facebook.com/your-facebook-page" target="_blank">
                        <i class="fa-brands fa-facebook mt-4"></i>
                    </a>

                    <a href="https://www.instagram.com/your-instagram-account" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>

                    <a href="https://twitter.com/your-twitter-account" target="_blank">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1">
        <div class="max-w-md  p-8 bg-white rounded-lg shadow-md mt-8">
            <form action="index_contact_us.php" class="grid grid-cols-1 gap-6" method="POST">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 p-2.5 w-full text-sm text-gray-800 bg-gray-100 rounded-md focus:ring-primary-500 focus:border-primary-500 border-gray-300"
                        placeholder="your name" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Your email</label>
                    <input type="email" id="email" name="email"
                        class="mt-1 p-2.5 w-full text-sm text-gray-800 bg-gray-100 rounded-md focus:ring-primary-500 focus:border-primary-500 border-gray-300"
                        placeholder="name@example.com" required>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" id="subject" name="subject"
                        class="mt-1 p-2.5 w-full text-sm text-gray-800 bg-gray-100 rounded-md focus:ring-primary-500 focus:border-primary-500 border-gray-300"
                        placeholder="How can we assist you?" required>
                </div>
                <div class="col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700">Your message</label>
                    <textarea id="message" name="message" rows="4"
                        class="mt-1 p-2.5 w-full text-sm text-gray-800 bg-gray-100 rounded-md focus:ring-primary-500 focus:border-primary-500 border-gray-300"
                        placeholder="Leave a comment..." required></textarea>

                </div>
                <button type="submit" name="submit" value="Send message "
                    class="col-span-2 py-3 px-5 text-sm font-medium text-white rounded-md focus:ring-4 focus:outline-none focus:ring-primary-300 bg-blue-500">
                    Send message
                </button>
            </form>

        </div>
    </div>
</section>






</html>