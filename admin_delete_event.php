<?php
include('config/db_connect.php');

if (isset($_GET['event_id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['event_id']);

    //Delete from announcements
    $deleteQuery6 = "DELETE FROM announcements WHERE event_id = '$event_id'";
    $deleteQuery6Result = mysqli_query($conn,$deleteQuery6);
    
    // Delete from vol_participate_event
    $deleteQuery1 = "DELETE FROM vol_participate_event WHERE event_id = '$event_id'";
    if (mysqli_query($conn, $deleteQuery1)) {

        // Delete from club_host_event or authority_host_event based on conditions
        $getHostEventTable = "SELECT req_club_id, faculty_id FROM event_details WHERE id = $event_id";
        $result = $conn->query($getHostEventTable);

        if ($result !== false) {
            $row = $result->fetch_assoc();
            $reqClubId = $row['req_club_id'];
            $reqAuthorityId = $row['faculty_id'];

            if ($reqAuthorityId == 0) {
                $deleteQuery2 = "DELETE FROM club_host_event WHERE event_id = '$event_id' AND club_id = '$reqClubId'";
            } elseif ($reqClubId == 0) {
                $deleteQuery2 = "DELETE FROM authority_host_event WHERE event_id = '$event_id' AND authority_id = '$reqAuthorityId'";
            }

           
            if (isset($deleteQuery2) && mysqli_query($conn, $deleteQuery2)) {

              
                $deleteQuery3 = "DELETE FROM event_details WHERE id = '$event_id'";
                
                if (mysqli_query($conn, $deleteQuery3)) {
                 
                    header("Location: admin_manage_event.php");
                    exit();
                } else {
                   
                    echo "Error deleting event_details: " . mysqli_error($conn);
                }
            } else {
            
                echo "Error deleting host event: " . mysqli_error($conn);
            }
        } else {
      
            echo "Error fetching data from event_details: " . mysqli_error($conn);
        }
    } else {
       
        echo "Error deleting participation records: " . mysqli_error($conn);
    }
} else {
    
    header("Location: admin_manage_event.php");
    exit();
}
?>