<?php
session_start();
 $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }

include('config/db_connect.php');

$student_id = '';
$errors = array(
    'name' => '',
    'email' => '',
    'badge_id' => '',
    'dept' => '',
    'ban_status' => '',
    'ban_end_date' => ''
);

if (isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

    
    $query = "SELECT * FROM volunteer WHERE student_id = '$student_id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $volunteer = $result->fetch_assoc();

      
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
           
            $newName = mysqli_real_escape_string($conn, $_POST['name']);
            $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
            $newPoints = mysqli_real_escape_string($conn, $_POST['points']);
            $newDept = mysqli_real_escape_string($conn, $_POST['dept']);
            $newBadgeID = mysqli_real_escape_string($conn, $_POST['badge_id']);
            $newBanStatus = mysqli_real_escape_string($conn, $_POST['ban_status']);
            $newBanEndDate = mysqli_real_escape_string($conn, $_POST['ban_end_date']);
            $newPenaltyCount = mysqli_real_escape_string($conn, $_POST['penalty_count']);

            
            if (empty($newName)) {
                $errors['name'] = 'Name cannot be empty.';
            }

            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format.';
            }

            if (empty($newDept)) {
                $errors['dept'] = 'Department cannot be empty.';
            }

            if ($newBanStatus !== 'Banned' && $newBanStatus !== 'Active') {
                $errors['ban_status'] = 'Ban status should be Banned or Active.';
            }


           
            $updateQuery = "UPDATE volunteer SET 
                name = '$newName', 
                email = '$newEmail', 
                points = '$newPoints', 
                dept = '$newDept', 
                badge_id = '$newBadgeID', 
                ban_status = '$newBanStatus', 
                ban_end_date = '$newBanEndDate', 
                penalty_count = '$newPenaltyCount'
                WHERE student_id = '$student_id'";

            $conn->query($updateQuery);

            
            header("Location: admin_vol_page.php");
            exit();
        }
    } else {
       
        header("Location: admin_vol_page.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Volunteer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"
        type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>

<body>
    <section class="container mx-auto mt-6 text-gray-800">
        <h4 class="text-2xl font-bold text-center">Edit Volunteer</h4>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
            action="admin_edit_vol.php?student_id=<?php echo $student_id; ?>" method="POST">

            <!-- Name Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" name="name" placeholder="Enter your name"
                    value="<?php echo htmlspecialchars($volunteer['name']); ?>">
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="email" name="email" placeholder="Enter a valid email"
                    value="<?php echo htmlspecialchars($volunteer['email']); ?>">
            </div>

            <!-- Points Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="points">
                    Points:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="points" type="text" name="points" placeholder="Enter points"
                    value="<?php echo htmlspecialchars($volunteer['points']); ?>">
            </div>

            <!-- Dept Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="dept">
                    Dept:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="dept" type="text" name="dept" placeholder="Enter your department name"
                    value="<?php echo htmlspecialchars($volunteer['dept']); ?>">
            </div>

            <!-- Badge ID Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="badge_id">
                    Badge ID:
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="badge_id" name="badge_id">
                    <?php for ($i = 0; $i <= 6; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php echo ($volunteer['badge_id'] == $i) ? 'selected' : ''; ?>>
                        <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>


            <!-- Ban Status Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ban_status">
                    Ban Status:
                </label>
                <select
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="ban_status" name="ban_status">
                    <option value="Banned" <?php echo ($volunteer['ban_status'] == 'Banned') ? 'selected' : ''; ?>>
                        Banned</option>
                    <option value="Active" <?php echo ($volunteer['ban_status'] == 'Active') ? 'selected' : ''; ?>>
                        Active</option>
                </select>
            </div>


            <!-- Ban End Date Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ban_end_date">
                    Ban End Date:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="ban_end_date" type="datetime-local" name="ban_end_date" placeholder="Enter ban end date"
                    value="<?php echo htmlspecialchars($volunteer['ban_end_date']); ?>">
            </div>


            <!-- Penalty Count Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="penalty_count">
                    Penalty Count:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="penalty_count" type="text" name="penalty_count" placeholder="Enter penalty count"
                    value="<?php echo htmlspecialchars($volunteer['penalty_count']); ?>">
            </div>


            <div class="flex justify-center space-x-4">

                <!-- SweetAlert confirmation -->
                <a href="#" onclick="confirmDelete()"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</a>

                <input type="submit" name="submit" value="Update"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">

            </div>
            <div class="text-center mt-4">
                <a href="admin_vol_page.php" class="link link-hover text-blue-500 ">Back to Home</a>
            </div>

        </form>

    </section>

    <script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = 'admin_delete_vol.php?student_id=<?php echo $student_id; ?>';
            }
        });
    }
    </script>

</body>

</html>