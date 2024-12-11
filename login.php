<?php
// Establish a database connection
$host = 'localhost';  // Your database host
$dbname = 'slicehouse_db';  // Database name
$username = 'root';  // Your database username
$password = '';  // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form data is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];  // In a real-world scenario, hash the password before comparing

        // Query to check if the user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Start session if user is authenticated
            session_start();
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['username'] = $user['username'];

            // Insert session into the `user_sessions` table
            $stmt = $pdo->prepare("INSERT INTO user_sessions (userID) VALUES (:userID)");
            $stmt->bindParam(':userID', $user['userID']);
            $stmt->execute();

            // Redirect to the logged-in page
            header('Location: Logged_In.php');
        } else {
             "Invalid credentials!";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
