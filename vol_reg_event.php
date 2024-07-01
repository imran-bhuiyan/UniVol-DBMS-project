<?php 
session_start();
if (!isset($_SESSION['vol_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: volunteerLogin.php");
    exit();
}


include('config/db_connect.php');

$id;
$student_id;

if(isset($_GET['id'])){
    $id=mysqli_real_escape_string($conn,$_GET['id']);
}

if(isset($_GET['student_id'])){
    $student_id=mysqli_real_escape_string($conn,$_GET['student_id']);
}

$sql2="SELECT * FROM event_details WHERE id IN (SELECT id FROM event_details WHERE id = $id)";
$result233 = mysqli_query($conn,$sql2);
$fetch = mysqli_fetch_assoc($result233);
$req_member= $fetch['vol_count'];
$remaining_member=$fetch['remaining_member'];

$sql6="SELECT student_id FROM volunteer where student_id in (SELECT student_id FROM vol_participate_event WHERE student_id=$student_id AND event_id=$id)" ;
$check=mysqli_query($conn,$sql6);
$dd=mysqli_fetch_assoc($check);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>SweetAlert Example</title>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
    }
    </style>
</head>

<body>

    <?php if (mysqli_num_rows($check) > 0) { ?>

    <script>
    swal({
        title: "Error",
        text: "You have already registered",
        icon: "error"
    }).then(function() {
        // Redirect to vol_upcoming_event.php
        window.location.href =
            'vol_upcoming_event.php?id=<?php echo $id; ?>&student_id=<?php echo $student_id; ?>';
    });
    </script>

    <?php } else if ($remaining_member > 0) { ?>

    <?php
        $remaining_member--;
        $sql3="UPDATE event_details set remaining_member=$remaining_member WHERE id in (SELECT id FROM event_details WHERE id = $id)";
        mysqli_query($conn,$sql3);

        $sql="insert into vol_participate_event(student_id,event_id) values($student_id,$id)";
        mysqli_query($conn,$sql);
        ?>

    <script>
    swal({
        title: "Success",
        text: "Congratulations!! Your Registration has successfully completed and you've got 10 points. ENJOY!",
        icon: "success"
    }).then(function() {
        // Redirect to vol_upcoming_event.php
        window.location.href =
            'vol_upcoming_event.php?id=<?php echo $id; ?>&student_id=<?php echo $student_id; ?>';
    });
    </script>

    <?php
        $sql4="SELECT* FROM volunteer where student_id=$student_id";
        $vol = mysqli_query($conn,$sql4);
        $fetch3 = mysqli_fetch_assoc($vol);
        $point=$fetch3['points'];
        $point+=10;
        $sql5="UPDATE volunteer set points=$point where student_id=$student_id";
        mysqli_query($conn,$sql5);
        ?>

    <?php } else { ?>

    <script>
    swal({
        title: "Error",
        text: "Sorry! You can't register because our slot is already full.",
        icon: "error"
    }).then(function() {
        // Redirect to vol_upcoming_event.php
        window.location.href =
            'vol_upcoming_event.php?id=<?php echo $id; ?>&student_id=<?php echo $student_id; ?>';
    });
    </script>

    <?php } ?>

</body>

</html>