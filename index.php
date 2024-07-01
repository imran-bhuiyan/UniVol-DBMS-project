<?php 

include('config/db_connect.php');


$query1 = "SELECT* FROM pages WHERE id = 4";
$query2 = "SELECT* FROM pages WHERE id = 5";

$result1 = $conn->query($query1);
$result2 = $conn->query($query2);

$row1 = $result1->fetch_assoc();
$row2 = $result2->fetch_assoc();

$content1 = $row1['description'];
$content2 = $row2['description'];


if (isset($_POST['getStarted'])) {
    header("Location: index_choose_option.php");
    exit();
}



 ?>


<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
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


<?php include ('templates/header.php'); ?>




<section>
    <div class="hero min-h-[80vh]" style="background-image: url(logo/vol_home1.jpg);">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold text-white">UniVol</h1>
                <p class="mb-5 text-white">Your Ultimate Volunteer Management System for Universities!</p>
                <form method="post">
                    <button type="submit" name="getStarted" class="btn btn-primary">Get Started</button>
                </form>

            </div>
        </div>
    </div>
</section>

<section>
    <div class="flex gap-10 max-w-4xl mx-auto text-black p-40">
        <div class="flex flex-1 text-center ">
            <p class="text-6xl font-bold text-right"><span class="text-red-500">KNOW</span> <br> US
            </p>
        </div>
        <div class="">
            <p class="font-semibold"><?php echo $content1; ?> </p>
        </div>
    </div>
</section>

<section>
    <div class="flex gap-10 max-w-4xl mx-auto text-black p-40">
        <div class="flex flex-1 text-center ">
            <p class="text-6xl font-bold text-right"><span class="text-blue-500">JOIN</span> <br> US
            </p>
        </div>
        <div class="">
            <p class="font-semibold"><?php echo $content2; ?> </p>
        </div>
    </div>

</section>

</html>