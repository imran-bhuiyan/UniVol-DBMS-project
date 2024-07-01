<?php
session_start();

include('config/db_connect.php');

    $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }

$authority_id = '';
$authority_name = ''; 

$result = null; 

if (isset($_POST['submit'])) {
   
    $authority_name = $_POST['authority_search']; 

    
    $authority_name = mysqli_real_escape_string($conn, $authority_name);

    
    $query = "SELECT id, name, type FROM authority WHERE name LIKE '%$authority_name%'";
    $result = $conn->query($query);
}elseif (isset($_POST['view_all'])) {
    
    $query = "SELECT id, name,type FROM authority";
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

    <form action="admin_manage_authority.php" method="POST">
        <label for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <input type="search" id="default-search"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search by authority name" name="authority_search" value="<?php echo $authority_id; ?>">
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
                        Authority ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Authority Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Authority Type
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
                             echo "<td class='px-6 py-4 font-medium whitespace-nowrap'>" . $row['type'] . "</td>";
                            echo "<td class='px-6 py-4'><a href='admin_edit_authority.php?authority_id=" . $row['id'] . "' class='font-medium text-blue-600 dark:text-blue-500 hover:underline'> Edit</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No Members found.</td></tr>";
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