<?php
include('config/db_connect.php');

if (isset($_GET['authority_id'])) {
    $authority_id = mysqli_real_escape_string($conn, $_GET['authority_id']);

    // Delete the event with the given ID
    $deleteQuery = "DELETE FROM authority WHERE id = '$authority_id'";
    
    $deleteQuery1 = "DELETE from authority_host_event where authority_id = '$authority_id' ";
    $result = mysqli_query($conn,$deleteQuery1);
    
    $updateQuery = "UPDATE event_details SET faculty_id = 0 WHERE faculty_id = '$authority_id'";
    $updateResult = mysqli_query($conn,$updateQuery);
    
    $deleteQuery2= "DELETE FROM announcements where authority_id ='$authority_id'";
    $deleteQuery2Result = mysqli_query($conn,  $deleteQuery2);

    

    
   

    if (mysqli_query($conn, $deleteQuery)) {
       
        header("Location: admin_manage_authority.php");
        exit();
    } else {
       
        echo "Error deleting event: " . mysqli_error($conn);
    }
} else {
   
    header("Location: admin_manage_authority.php");
    exit();
}
?>