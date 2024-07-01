<?php


$optionLinks = array(
    "Volunteer" => "volunteerSignup.php", 
    "Club" => "clubSignup.php",           
    "Authority" => "authoritySignup.php", 
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Choose Option</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<?php include ('templates/header.php'); ?>

<body class="bg-gray-100">
    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-bold mb-5 text-center text-blue-500"> Choose,Who You Are!</h1>

        <div class="flex justify-center">
            <div class="w-96 ">
                <?php foreach ($optionLinks as $option => $link) : ?>
                <div class="bg-white p-4 rounded-md shadow-md mb-4">
                    <h2 class="text-xl font-semibold mb-2"><?php echo $option; ?></h2>
                    <a href="<?php echo $link; ?>" class="text-blue-500">select</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div>
        <p class="text-center">Fill Some Informations & Start Your Journey With Us!</p>
    </div>
</body>

</html>