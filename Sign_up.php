<?php 
$conn = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($conn, "slicehouse_db");

if (isset($_POST["signup"])) {
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $password = $_POST['custPassword'];
    $confirmPassword = $_POST['custConfirmPass'];
    $username = $_POST['custUsername'];
    $email = $_POST['email'];

    // Validate password length
    if (strlen($password) >= 8) {
        // Password meets length requirement
    } else {
        echo "<script language='javascript'>alert('Password needs a minimum length of 8. Please try again.')</script>";
    }

    // Validate password for at least one uppercase letter
    if (!ctype_lower($password)) {
        // Password contains at least one uppercase letter
    } else {
        echo "<script language='javascript'>alert('Password needs at least 1 uppercase letter. Please try again.')</script>";
    }

    // Validate password for at least one special character
    if (preg_match('/[\'^£$%&*()}{@#~?!`><>,|=_+¬-]/', $password)) {
        // Password contains a special character
    } else {
        echo "<script language='javascript'>alert('Password needs at least 1 special character. Please try again.')</script>";
    }

    // Check if passwords match
    if ($password != $confirmPassword) {
        echo "<script language='javascript'>alert('Confirmation of password failed. Please input the correct password in both fields.')</script>";
    } else if (strlen($password) >= 8 && !ctype_lower($password)
        && preg_match('/[\'^£$%&*()}{@#~?!`><>,|=_+¬-]/', $password)
        && $password == $confirmPassword) {

        // Check if the email is already used
        $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $email_check_result = mysqli_query($conn, $email_check_query);
        if (mysqli_num_rows($email_check_result) > 0) {
            echo "<script language='javascript'>alert('This email is already registered. Please use a different one.')</script>";
        } else {
            // Insert into database if email is unique
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Always hash the password for security
            $query = "INSERT INTO users (firstName, lastName, username, password, email)
                      VALUES ('$firstname', '$lastname', '$username', '$hashed_password', '$email')";
            $query_exec = mysqli_query($conn, $query);

            if ($query_exec) {
                echo "<script language='javascript'>alert('Account successfully registered! You can log in now.')</script>";
                echo "<script>window.location.href='Log_in.php';</script>";
            } else {
                echo "<script language='javascript'>alert('Account registration failed. Please try again later.')</script>";
                echo "<script>window.location.href='Sign_up.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up - Slice House</title>
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
    .signup-box {
      padding: 20px;
      max-width: 500px;
      background: rgba(0, 0, 0, 0.8);
      color: white;
      border-radius: 15px;
      text-align: center;
    }
    .signup-box input {
      margin-bottom: 15px;
      padding: 10px;
      width: 96%;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .signup-box button {
      width: 100%;
      padding: 10px;
      background: #8ED438;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      cursor: pointer;
    }
    .signup-box a {
      color: #8ED438;
      text-decoration: none;
    }
    .signup-box a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="bgimg">
    <div class="signup-box">
      <h1>Sign Up</h1>
      <form action="Sign_Up.php" method="POST">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="text" name="custUsername" placeholder="Choose a Username" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="custPassword" placeholder="Create a Password" required>
        <input type="password" name="custConfirmPass" placeholder="Confirm Password" required>
        <button type="submit" name="signup">Sign Up</button>
      </form>
      <p>Already have an account? <a href="Log_In.php">Log In</a></p>
    </div>
  </div>
</body>
</html>