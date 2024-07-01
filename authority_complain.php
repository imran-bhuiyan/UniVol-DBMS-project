<?php
session_start();

if (!isset($_SESSION['autho_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: authorityLogin.php");
    exit();
}

include('config/db_connect.php');

$vol_id = $vol_name = $event_id = $details = '';
$errors = array(
    'vol_id' => '', 'vol_name' => '', 'event_id' => '', 'details' => ''
);

if (isset($_POST['submit'])) {
    
    $vol_id = isset($_POST['vol_id']) ? $_POST['vol_id'] : '';
    $vol_name = isset($_POST['vol_name']) ? $_POST['vol_name'] : '';
    $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : '';
    $details = isset($_POST['details']) ? $_POST['details'] : '';

    // Validate vol_id
    if (empty($vol_id)) {
        $errors['vol_id'] = 'Volunteer ID is required';
    }

    // Validate vol_name
    if (empty($vol_name)) {
        $errors['vol_name'] = 'Volunteer Name is required';
    }

    // Validate event_id
    if (empty($event_id)) {
        $errors['event_id'] = 'Event ID is required';
    } else {
        
        $event_id = mysqli_real_escape_string($conn, $event_id);
        $event_query = "SELECT * FROM event_details WHERE id = '$event_id'";
        $event_result = mysqli_query($conn, $event_query);

        if (mysqli_num_rows($event_result) == 0) {
            $errors['event_id'] = 'Event ID does not exist in the event_details table';
        }
    }

    // Validate details
    if (empty($details)) {
        $errors['details'] = 'Details are required';
    }

   
    if (empty(array_filter($errors))) {
       
        $vol_id = mysqli_real_escape_string($conn, $vol_id);
        $vol_name = mysqli_real_escape_string($conn, $vol_name);
        $volunteer_query = "SELECT * FROM volunteer WHERE student_id = '$vol_id' AND name = '$vol_name'";
        $volunteer_result = mysqli_query($conn, $volunteer_query);

        if (mysqli_num_rows($volunteer_result) > 0) {
         
            $vol_id = mysqli_real_escape_string($conn, $vol_id);
            $vol_name = mysqli_real_escape_string($conn, $vol_name);
            $event_id = mysqli_real_escape_string($conn, $event_id);
            $details = mysqli_real_escape_string($conn, $details);

            
            $sql = "INSERT INTO complain (vol_id, vol_name, event_id, details, progress)
                    VALUES ('$vol_id', '$vol_name', '$event_id', '$details', 'Pending')";

            
            if (mysqli_query($conn, $sql)) {
                
                header('Location: authority_event_details.php');
            } else {
                echo 'Query error: ' . mysqli_error($conn);
            }
        } else {
            $errors['vol_id'] = 'Volunteer ID and Name do not match';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('authority_header.php');?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVol - Submit Complaint</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <section class="container mx-auto mt-6 text-gray-800">

        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-2xl mx-auto" action="authority_complain.php"
            method="POST">
            <h4 class="text-2xl font-bold text-center">Make Complaint</h4>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="vol_id">
                    Volunteer ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="vol_id" type="text" name="vol_id" placeholder="Enter Volunteer ID"
                    value="<?php echo htmlspecialchars($vol_id) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['vol_id']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="vol_name">
                    Volunteer Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="vol_name" type="text" name="vol_name" placeholder="Enter Volunteer Name"
                    value="<?php echo htmlspecialchars($vol_name) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['vol_name']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="event_id">
                    Event ID:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="event_id" type="text" name="event_id" placeholder="Enter Event ID"
                    value="<?php echo htmlspecialchars($event_id) ?>">
                <div class="text-red-500 italic"> <?php echo $errors['event_id']; ?></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="details">
                    Details:
                </label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="details" name="details"
                    placeholder="Enter Complaint Details"><?php echo htmlspecialchars($details) ?></textarea>
                <div class="text-red-500 italic"> <?php echo $errors['details']; ?></div>
            </div>

            <div class="text-center">
                <input type="submit" name="submit" value="Submit Complaint"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
            </div>
            <div class="text-center mt-4">
                <a href="authority_event_details.php" class="link link-hover text-blue-500 ">Back to Home</a>
            </div>

        </form>
    </section>

</body>

</html>