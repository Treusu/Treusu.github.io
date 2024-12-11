// add_to_cart.php
<?php
session_start();
include 'db_connection.php';  // Assume this file connects to the database

if (isset($_SESSION['userID']) && isset($_POST['productID']) && isset($_POST['quantity'])) {
    $userID = $_SESSION['userID'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];

    // Insert product into cart
    $stmt = $pdo->prepare("INSERT INTO cart_items (userID, productID, quantity) VALUES (:userID, :productID, :quantity)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':productID', $productID);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->execute();
}
?>
