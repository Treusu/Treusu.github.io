<?php
// Start the PHP session (if needed)
session_start(); // Uncomment if you are managing user sessions

// Database connection
$host = 'localhost'; 
$db = 'slicehouse_db';
$user = 'root'; // Replace with your DB username
$pass = ''; // Replace with your DB password
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

// Retrieve the total amount (from cart/session or as POST data)
$totalAmount = isset($_POST['total']) ? (float) filter_var($_POST['total'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0.00;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment-method'])) {
    $paymentMethod = $_POST['payment-method'];
    $userID = $_SESSION['userID'] ?? 7; // Replace with the logged-in user's ID

    if (!$userID) {
        die("User not logged in.");
    }

    try {
        // Prepare and execute the query
        $stmt = $pdo->prepare("INSERT INTO payments (userID, paymentMethod, amount) VALUES (:userID, :paymentMethod, :amount)");
        $stmt->execute([
            ':userID' => $userID,
            ':paymentMethod' => $paymentMethod,
            ':amount' => $totalAmount
        ]);

        echo "<script>
                alert('Payment successful! Total Amount Paid: PHP " . number_format($totalAmount, 2) . "');
                window.location.href='receipt_page.php';
              </script>";
    } catch (PDOException $e) {
        echo "<script>alert('Payment failed: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Payment - Slice House</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: "Open Sans", sans-serif;
      background-color: #000;
    }
    .bgimg {
      background-image: url(https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExcGR6ZTcwZzJ2OGVubTJmb2Rra3lwcnZnMGhyaWh5aGpmM211MWpjNyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/1wZzLkh22DWpzqmmRz/giphy.webp);
      background-size: cover;
      background-position: center;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .payment-box {
      padding: 20px;
      max-width: 400px;
      background: rgba(0, 0, 0, 0.8);
      color: white;
      border-radius: 15px;
      text-align: center;
    }
    .payment-box select, .payment-box button {
      margin-bottom: 15px;
      padding: 10px;
      width: 100%;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .payment-box button {
      background: #F79722;
      color: white;
      font-size: 18px;
      cursor: pointer;
    }
    .payment-box a {
      color: #F79722;
      text-decoration: none;
    }
    .payment-box a:hover {
      text-decoration: underline;
    }
    #qr-space {
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="bgimg">
    <div class="payment-box">
      <h1>Payment</h1>
      <p>Total Amount to Pay: <strong>PHP <?php echo number_format($totalAmount, 2); ?></strong></p>
      <form action="" method="POST">
        <input type="hidden" name="total" value="<?php echo $totalAmount; ?>">
        <select id="payment-method" name="payment-method" required>
          <option value="" disabled selected>Select Payment Method</option>
          <option value="cash">Cash</option>
          <option value="gcash">GCash</option>
        </select>
        <div id="qr-space">
          <p style="color: #F79722;">QR code will appear here upon selection.</p>
        </div>
        <button type="submit">Proceed to Pay</button>
      </form>
      <p>Return to <a href="Logged_in.php">Menu</a></p>
    </div>
  </div>
  <script>
    document.getElementById('payment-method').addEventListener('change', function() {
      const qrSpace = document.getElementById('qr-space');
      if (this.value === 'gcash') {
        qrSpace.innerHTML = '<img src="gcash_qr.png" alt="GCash QR Code" style="max-width: 100%; border-radius: 10px;">';
      } else {
        qrSpace.innerHTML = '<p style="color: #F79722;">No QR code needed for cash payment.</p>';
      }
    });
  </script>
</body>
</html>
