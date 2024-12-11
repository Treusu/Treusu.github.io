<?php
// getMenuItems.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "slicehouse_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch menu items
$pizzaQuery = "SELECT * FROM menu_items WHERE category = 'Pizza'";
$saladQuery = "SELECT * FROM menu_items WHERE category = 'Salad'";
$starterQuery = "SELECT * FROM menu_items WHERE category = 'Starter'";

$pizzaResult = $conn->query($pizzaQuery);
$saladResult = $conn->query($saladQuery);
$starterResult = $conn->query($starterQuery);

$pizzaItems = [];
$saladItems = [];
$starterItems = [];

// Prepare the data for each section
while ($row = $pizzaResult->fetch_assoc()) {
  $pizzaItems[] = $row;
}
while ($row = $saladResult->fetch_assoc()) {
  $saladItems[] = $row;
}
while ($row = $starterResult->fetch_assoc()) {
  $starterItems[] = $row;
}

// Return the data as JSON
echo json_encode([
  'pizza' => $pizzaItems,
  'salads' => $saladItems,
  'starters' => $starterItems
]);

$conn->close();
?>
