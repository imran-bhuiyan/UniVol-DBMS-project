<?php
session_start();
if (!isset($_SESSION['vol_id'])) {
    header("Location: volunteerlogin.php");
    exit();
}

include('config/db_connect.php');

// Comment handling
if (isset($_POST['submit_comment'])) {
    $post_id = $_POST['post_id'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $user_id = $_SESSION['vol_id'];

    $commentSql = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$comment')";

    if (mysqli_query($conn, $commentSql)) {
        header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page 
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

// Post creation 
if (isset($_POST['submit_post'])) {
    $content = mysqli_real_escape_string($conn, $_POST['post_content']);
    $student_id = $_SESSION['vol_id'];

    $postSql = "INSERT INTO posts (student_id, content) VALUES ('$student_id', '$content')";

    if (mysqli_query($conn, $postSql)) {
        header("Location: " . $_SERVER['PHP_SELF']); 
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

// Fetch posts 
$sql = "SELECT posts.id, posts.content, posts.created_at, volunteer.name
        FROM posts
        JOIN volunteer ON posts.student_id = volunteer.student_id
        ORDER BY posts.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('volunteer_header.php'); ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-4 text-center">Welcome to Volunteer Social Platform</h1>

        <!-- Form for creating new posts -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mb-6">
            <label for="post_content" class="block text-sm font-semibold mb-2">Create a new post:</label>
            <textarea name="post_content" class="w-full px-3 py-2 border rounded-md" required></textarea>
            <button type="submit" name="submit_post"
                class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md">Post</button>
        </form>

        <!-- Display posts -->
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="bg-white p-4 mb-4 rounded-md shadow">';
            echo '<p class="text-lg font-semibold mb-2 text-green-500">' . htmlspecialchars($row['name']) . '</p>';
            echo '<p class="mb-2"><strong>Content:</strong> ' . htmlspecialchars($row['content']) . '</p>';
            echo '<p class="mb-2"><strong>Posted at:</strong> ' . $row['created_at'] . '</p>';
            
         // Display comments for each post
                echo '<div class="comments">';
                $postId = $row['id'];
                $commentSql = "SELECT comments.user_id, comments.content, volunteer.name 
               FROM comments 
               JOIN volunteer ON comments.user_id = volunteer.student_id 
               WHERE comments.post_id = $postId 
               ORDER BY comments.created_at DESC";
               
                $commentResult = mysqli_query($conn, $commentSql);

                while ($comment = mysqli_fetch_assoc($commentResult)) {
                    echo '<p class="text-gray-500"><strong>' . htmlspecialchars($comment['name']) . ':</strong> ' . htmlspecialchars($comment['content']) . '</p>';
                        }
                    echo '</div>';


            // Comment form for post
            echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" class="mt-2">';
            echo '<input type="hidden" name="post_id" value="' . $postId . '">';
            echo '<textarea name="comment" placeholder="Add a comment" class="w-full px-3 py-2 border rounded-md" required ></textarea>';
            echo '<button type="submit" name="submit_comment" class="bg-blue-500 text-white px-4 py-2 rounded-md">Post Comment</button>';
            echo '</form>';

            echo '</div>';
        }
        ?>
    </div>

</body>

</html>