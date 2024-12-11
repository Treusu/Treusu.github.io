<?php
// Start the session
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

// Get the userID from session
$userID = $_SESSION['userID'] ?? null; 

if (!$userID) {
    die("User not logged in.");
}

// Retrieve the most recent payment record for the user
$stmt = $pdo->prepare("SELECT * FROM payments WHERE userID = :userID ORDER BY paymentDate DESC LIMIT 1");
$stmt->execute([':userID' => $userID]);
$payment = $stmt->fetch();

// Retrieve user details
$stmt = $pdo->prepare("SELECT firstName, lastName FROM users WHERE userID = :userID");
$stmt->execute([':userID' => $userID]);
$user = $stmt->fetch();
$userName = $user['firstName'] . " " . $user['lastName'];

// Check if payment exists
if (!$payment) {
    die("No payment found.");
}

$paymentDate = $payment['paymentDate'];
$paymentMethod = $payment['paymentMethod'];
$amountPaid = $payment['amount'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Receipt</title>
  <link rel="stylesheet" href="restaurant.css">
  <style>
    /* Gradient background and font styling */
    body, html {
      height: 100%;
      font-family: "Open Sans", sans-serif;
      background: linear-gradient(45deg, #ff9a8b, #ff6a00, #ff6a00);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Navbar Styling */
    .navbar {
      font-size: 18px;
      background-color: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }

    .navbar a {
      padding: 10px 20px;
      text-decoration: none;
      color: white;
      font-size: 18px;
    }

    .navbar a:hover {
      background-color: #ff6347;
      color: white;
    }

    /* Receipt Styling */
    .receipt-container {
      background: white;
      border-radius: 10px;
      padding: 30px;
      max-width: 600px;
      margin: 120px auto 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .receipt-container h1 {
      color: #4CAF50;
    }

    .details {
      font-size: 1rem;
      color: #333;
      margin: 15px 0;
    }

    .details b {
      font-weight: bold;
    }

    .thank-you {
      font-size: 1.1rem;
      color: #4CAF50;
      margin-top: 20px;
    }

    /* Footer Styling */
    .navbar .right {
      position: relative;
      right: 20px;
    }

    .navbar a {
      margin-left: 10px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="#">Home</a>
    <a href="#">Menu</a>
    <a href="#">Contact</a>
    <div class="right">
      <a href="logout.php" style="color: white;">Log Out</a>
    </div>
  </div>

  <!-- Receipt Content -->
  <div class="receipt-container">
    <h1>Thank You for Your Payment!</h1>
    <p class="details"><b>Payment Date:</b> <?php echo htmlspecialchars($paymentDate); ?></p>
    <p class="details"><b>Customer:</b> <?php echo htmlspecialchars($userName); ?></p>
    <p class="details"><b>Payment Method:</b> <?php echo htmlspecialchars($paymentMethod); ?></p>
    <p class="details"><b>Amount Paid:</b> PHP <?php echo number_format($amountPaid, 2); ?></p>
    <p class="thank-you">We appreciate your business at Slice House. Enjoy your meal!</p>
  </div>
</body>
</html>
