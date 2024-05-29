<?php
session_start();

if (!isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) {
    header("Location: ../admin_home_page.php");
    exit();
}

$config = require("../config.php");
require("../model/DB.php");

$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->dbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    // Fetch user details
    $sqlQuery = "SELECT * FROM `registerDetails` WHERE `id` = $userId";
    $result = mysqli_query($conn, $sqlQuery);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = intval($_POST['id']);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $courseName = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_SPECIAL_CHARS);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    // Update user details
    $sqlUpdate = "UPDATE `registerDetails` SET `Name` = ?, `EmailAddress` = ?, `CourseName` = ?, `is_admin` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("sssii", $name, $email, $courseName, $isAdmin, $userId);

    if ($stmt->execute()) {
        echo "User updated successfully.";
        header("Location: ../view_users.php");
        exit();
    } else {
        echo "Error updating user.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit User</h1>
        <form method="post" action="edit_user.php" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $user['Name']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['EmailAddress']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="course" class="block text-gray-700 font-bold mb-2">Course:</label>
                <input type="text" id="course" name="course" value="<?php echo $user['CourseName']; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="isAdmin" class="block text-gray-700 font-bold mb-2">Admin:</label>
                <input type="checkbox" id="isAdmin" name="isAdmin" <?php echo $user['isAdmin'] ? 'checked' : ''; ?> class="mr-2 leading-tight">
            </div>
            <div class="flex items-center justify-between">
                <input type="submit" value="Update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>
        </form>
    </div>
</body>
</html>
