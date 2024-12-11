<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "slicehouse_db");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the username and password match
    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify password (using password hashing for security)
        if (password_verify($password, $row['password'])) {
            // Start session and store user data
            session_start();
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['username'] = $row['username'];

            // Redirect to the dashboard or home page
            alert("You have logged in succesfully!");
            header("Location: Logged_In.php");
            exit();
        } else {
            $error_message = "Invalid username or password!";
        }
    } else {
        $error_message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Log In - Slice House</title>
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
    .login-box {
      padding: 20px;
      max-width: 400px;
      background: rgba(0, 0, 0, 0.8);
      color: white;
      border-radius: 15px;
      text-align: center;
    }
    .login-box input {
      margin-bottom: 15px;
      padding: 10px;
      width: 95%;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .login-box button {
      width: 100%;
      padding: 10px;
      background: #F79722;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      cursor: pointer;
    }
    .login-box a {
      color: #F79722;
      text-decoration: none;
    }
    .login-box a:hover {
      text-decoration: underline;
    }
    .error-message {
      color: red;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="bgimg">
    <div class="login-box">
      <h1>Log In</h1>
      <?php if (isset($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
      <?php endif; ?>
      <form method="POST" action="LogIn.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
      </form>
      <p>Don't have an account? <a href="Sign_Up.php">Sign Up</a></p>
    </div>
  </div>
</body>
</html>