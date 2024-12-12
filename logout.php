<?php
session_start();

// Database connection
$host = 'localhost'; 
$db = 'slicehouse_db';
$user = 'root'; 
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if user is logged in
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    // Record logout time in user_sessions
    $query = "UPDATE user_sessions SET logoutTime = NOW() WHERE userID = :userID AND logoutTime IS NULL";
    $stmt = $conn->prepare($query);
    $stmt->execute([':userID' => $userID]);

    // Destroy session
    session_unset();
    session_destroy();
}

// Redirect to home page
header("Location: index.php");
exit();
?>
