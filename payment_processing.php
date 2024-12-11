<?php
// Start the session (ensure the session is started)
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
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Ensure the total amount is passed correctly via POST data or session
$totalAmount = isset($_POST['total']) ? (float) filter_var($_POST['total'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0.00;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment-method'])) {
    $paymentMethod = $_POST['payment-method'];
    $userID = $_SESSION['userID'] ?? null; // Get userID from session (replace with actual user session variable)

    if (!$userID) {
        die("User not logged in.");
    }

    try {
        // Insert payment into the payments table (do not include paymentID here)
        $stmt = $pdo->prepare("INSERT INTO payments (userID, paymentMethod, amount) VALUES (:userID, :paymentMethod, :amount)");
        $stmt->execute([
            ':userID' => $userID,
            ':paymentMethod' => $paymentMethod,
            ':amount' => $totalAmount
        ]);

        // No redirection with paymentID
        header("Location: receipt_page.php");
        exit();

    } catch (PDOException $e) {
        echo "<script>alert('Payment failed: " . $e->getMessage() . "');</script>";
    }
} else {
    // Handle the case where no payment method or total amount is provided
    die("Invalid request. Payment method or total amount not provided.");
}
?>
