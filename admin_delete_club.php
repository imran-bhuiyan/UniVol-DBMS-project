<?php
include('config/db_connect.php');

if (isset($_GET['club_id'])) {
    $club_id = mysqli_real_escape_string($conn, $_GET['club_id']);

   
    $deleteQuery = "DELETE FROM club WHERE id = '$club_id'";
    
    $deleteQuery1 = "DELETE FROM club_host_event WHERE club_id='$club_id' ";
    $result = mysqli_query($conn,$deleteQuery1);
    
    $updateQuery = "UPDATE event_details SET req_club_id = 0 WHERE req_club_id = '$club_id'";
    $updateResult = mysqli_query($conn,$updateQuery);

    $deleteQuery2 = "DELETE FROM announcements WHERE club_id='$club_id' ";
    $result = mysqli_query($conn,$deleteQuery2);

    

    if (mysqli_query($conn, $deleteQuery)) {
      
        header("Location: admin_manage_club.php");
        exit();
    } else {
       
        echo "Error deleting event: " . mysqli_error($conn);
    }
} else {
   
    header("Location: admin_manage_club.php");
    exit();
}
?>