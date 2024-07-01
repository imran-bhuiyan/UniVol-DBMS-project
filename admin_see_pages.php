<?php
session_start();
 $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }
    
include('config/db_connect.php');


$query = "SELECT * FROM pages";
$result = $conn->query($query);


if (!$result) {
    die("Error fetching pages: " . $conn->error);
}
?>


<html>
<?php include('admin_header.php') ?>

<body>
    <div class="container mx-auto mt-6 text-gray-800">
        <h4 class="text-2xl font-bold text-center mb-6">Admin Pages</h4>


        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row['id'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['name'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['description'] . "</td>";
                    echo "<td class='border px-4 py-2'><a href='admin_edit_pages.php?id=" . $row['id'] . "' class='text-blue-500'>Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>