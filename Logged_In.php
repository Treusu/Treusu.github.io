<?php
// Start the session
session_start();

// Database connection
$host = 'localhost';  // Adjust as needed
$username = 'root';  // Your database username
$password = '';  // Your database password
$dbname = 'slicehouse_db';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);

// Fetch user details from session
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Slice House - Logged In</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="restaurant.css">
  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <style>
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

    /* Navbar Styles */
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

    .navbar .menu {
      display: flex;
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

    .navbar .right {
      display: flex;
    }

    .navbar .right a {
      margin-left: 10px;
    }

    .navbar .right span {
      color: white;
      margin-left: 10px;
    }

    /* Adjusting Logout Button Position */
    .navbar .right {
      position: relative;
      right: 100px; /* Adjusted to avoid hiding behind the cart */
    }

    /* Styling the menu container */
    .menu-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 20px;
    }

    .menu-section {
      width: 90%;
      max-width: 900px;
      margin: 20px 0;
      border-radius: 10px;
      padding: 20px;
      background: linear-gradient(145deg, #fff, #f0f0f0);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .menu-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #eee;
    }

    .menu-item img {
      max-width: 100px;
      border-radius: 8px;
      margin-right: 15px;
    }

    .menu-item h2 {
      font-size: 1.2rem;
      margin-bottom: 5px;
    }

    .menu-item p {
      font-size: 0.9rem;
      color: #777;
    }

    .menu-item button {
      background-color: #ff6a00;
      color: white;
      padding: 6px 12px;
      font-size: 0.9rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .cart-button {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1000;
      background-color: orange;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 50%;
      font-size: 16px;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    /* Cart modal styles */
    .cart-modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2000;
      width: 70%;
      max-width: 400px;
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    .cart-modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 18px;
    }

    .cart-modal-body {
      margin-top: 10px;
      max-height: 250px;
      overflow-y: auto;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .cart-item button {
      background: red;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 4px 8px;
      cursor: pointer;
    }

    .cart-modal-footer {
      margin-top: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #totalPrice {
      font-size: 1.1rem;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-item">
      <a href="#menu">Home</a>
      <a href="#menu">Menu</a>
    </div>
    <div class="navbar-item right">
      <button id="cartButton" class="cart-button">🛒</button>
      <a href="logout.php" style="color: white; padding: 10px 20px; text-decoration: none;">Log Out</a>
    </div>
  </div>

  <!-- Menu Section -->
  <div class="menu-container" id="menu">
    <?php 
    // Fetch all categories from the database if available (optional)
    $categories = ['pizza', 'salad', 'starter']; // Updated to match your table's categories (case-sensitive)
    
    // Loop through each category
    foreach ($categories as $category) : 
    ?>
      <div class="menu-section">
        <h1><?php echo ucfirst($category); ?>s</h1> <!-- Make category name plural -->
        <p>Here are your favorite <?php echo strtolower($category); ?> options:</p>
        <div class="menu-scroll">
          <?php 
          // Fetch only 3 products per category from the database
          $query = "SELECT * FROM products WHERE category = '$category' LIMIT 3"; 
          $result = $conn->query($query);

          while ($row = $result->fetch_assoc()) : 
          ?>
            <div class="menu-item">
                <!-- Dynamic image from the database -->
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['productName']; ?>">
                <div>
                    <h2><?php echo $row['productName']; ?> <span class="price">₱<?php echo number_format($row['price'], 2); ?></span></h2>
                    <!-- Dynamic description from the database -->
                    <p><?php echo $row['description']; ?></p>
                </div>
                <!-- Add to Cart Button -->
                <button class="add-to-cart" data-item="<?php echo $row['productName']; ?>" data-price="<?php echo $row['price']; ?>">Add to Cart</button>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    <?php endforeach; ?>
</div>


  <!-- Cart Modal -->
  <div class="cart-modal" id="cartModal">
    <div class="cart-modal-header">
      <span>Shopping Cart</span>
      <button id="closeCart" style="font-size: 20px; background: none; border: none; color: red; cursor: pointer;">X</button>
    </div>
    <div class="cart-modal-body" id="cartBody">
      <!-- Cart items will appear here -->
    </div>
    <div class="cart-modal-footer">
      <form action="Payment.php" method="POST">
        <span id="totalPrice">Total: ₱0.00</span>
        <input type="hidden" name="total" value="<?php echo $totalPrice; ?>">
        <button type="submit">Checkout</button>
    </form>
    </div>
  </div>

  <script>
    let cart = [];
    let totalPrice = 0;

    $(".add-to-cart").click(function() {
        const item = $(this).data("item");
        const price = parseFloat($(this).data("price"));
        
        cart.push({ item, price });
        totalPrice += price;
        updateCartModal();
    });

    function updateCartModal() {
        let cartBody = $("#cartBody");
        cartBody.empty();

        cart.forEach(function(cartItem, index) {
            cartBody.append(`
                <div class="cart-item">
                    <span>${cartItem.item}</span>
                    <span>₱${cartItem.price.toFixed(2)}</span>
                    <button class="remove-item" data-index="${index}">Remove</button>
                </div>
            `);
        });

        $("#totalPrice").text(`Total: ₱${totalPrice.toFixed(2)}`);

        // Update the hidden input value for total in the form
        $("input[name='total']").val(totalPrice.toFixed(2));

        $(".remove-item").click(function() {
            const index = $(this).data("index");
            totalPrice -= cart[index].price;
            cart.splice(index, 1);
            updateCartModal();
        });
    }

    $("#cartButton").click(function() {
        $("#cartModal").fadeIn();
    });

    $("#closeCart").click(function() {
        $("#cartModal").fadeOut();
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
