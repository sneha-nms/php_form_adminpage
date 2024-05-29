<?php
session_start();

try {
    $config = require "../config.php";
    require "../model/DB.php";
    $databaseConnection = new DatabaseConnection($config);
    $conn = $databaseConnection->dbConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

      $fullname = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
      $password = $_POST['password'];
      $courseName = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_SPECIAL_CHARS);


        if (!$fullname || !$email || !$password || !$courseName) {
            throw new Exception("Invalid input");
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $_SESSION['email'] = $email;
        $_SESSION['password'] = $hashedPassword;
        $_SESSION['courseName'] = $courseName;

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO `registerDetails` (`Name`, `EmailAddress`, `Password`, `CourseName`) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            throw new Exception("Failed to prepare the SQL statement: " . $conn->error);
        }

        // Bind parameters to the SQL query
        $stmt->bind_param("ssss", $fullname, $email, $hashedPassword, $courseName);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Data not saved: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();

        echo "Data saved successfully";
        header("Location: ../login.php");
        exit();
    }
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>
