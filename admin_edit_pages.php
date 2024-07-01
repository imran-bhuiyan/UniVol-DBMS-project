<?php
session_start();
 $admin_dash = $_SESSION['admin_name'];
    if ($admin_dash == true) {

    }
    else{
        header("Location: adminLogin.php");
    }
    
include('config/db_connect.php');


if (isset($_GET['id'])) {
    $selectedPageId = intval($_GET['id']);

   
    $query = "SELECT * FROM pages WHERE id = $selectedPageId";
    $result = $conn->query($query);

    // Check for errors
    if (!$result) {
        die("Error fetching page details: " . $conn->error);
    }

   
    if ($result->num_rows > 0) {
        $selectedPageData = $result->fetch_assoc();
    } else {
        die("Page not found!");
    }
} else {
    die("Invalid request. Please provide a page ID.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_description'])) {
    $newDescription = $conn->real_escape_string($_POST['description']);

  
    $updateQuery = "UPDATE pages SET description = '$newDescription' WHERE id = $selectedPageId";
    $updateResult = $conn->query($updateQuery);

    header("Location: admin_see_pages.php");
    exit();
   
}
?>


<html>
<?php include('admin_header.php'); ?>

<body>
    <div class="container mx-auto mt-6 text-gray-800">
        <h4 class="text-2xl font-bold text-center mb-6">Edit Page</h4>


        <form method="post" action="">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                Page description:
            </label>
            <textarea id="description" name="description"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                rows="4"><?php echo htmlspecialchars($selectedPageData['description']); ?></textarea>

            <div class="mt-6">
                <input type="submit" name="update_description" value="Update"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </div>
        </form>
    </div>
</body>

</html>