<?php
session_start();

include('config/db_connect.php');

    $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }

$event_input = '';
$result = null; 

if (isset($_POST['submit'])) {
    
    $event_input = $_POST['event_id'];

    
    $event_input = mysqli_real_escape_string($conn, $event_input);
    
    // Giving Comand
    if (is_numeric($event_input)) {
        
        $query = "SELECT id, name FROM event_details WHERE id = '$event_input'";
    } else {
   
        $query = "SELECT id, name FROM event_details WHERE name LIKE '%$event_input%'";
    }

    $result = $conn->query($query);
}elseif (isset($_POST['view_all'])) {
   
    $query = "SELECT id, name FROM event_details";
    $result = $conn->query($query);
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <?php include('admin_header.php') ?>
</head>

<body>

    <form action="admin_manage_event.php" method="POST">

        <label for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" id="default-search"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search by event id" name="event_id" value="<?php echo $event_input; ?>">
            <button type="submit"
                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                name="submit">Search</button>
        </div>

        <div>
            <button type="submit" name="view_all"
                class="text-white absolute end-2.5 bottom-2.5 bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-400 dark:hover:bg-green-500 dark:focus:ring-green-600">
                View All
            </button>
        </div>
    </form>

    <?php
  
    if ($result !== null) {
    ?>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10">
        <table class="w-full text-sm text-left rtl:text-right ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Event ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Event Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Edit
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='px-6 py-4 font-medium whitespace-nowrap'>" . $row['id'] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row['name'] . "</td>";
                            echo "<td class='px-6 py-4'><a href='admin_edit_event.php?event_id=" . $row['id'] . "' class='font-medium text-blue-600 dark:text-blue-500 hover:underline'> Edit</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No Events found.</td></tr>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <?php
    }
    
    ?>




</body>

</html>