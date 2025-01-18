<?php
// Include the database connection
require 'db_connection.php';

// Initialize variables
$login_error = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data (username and password)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the username exists in the database
    $query = "SELECT * FROM userinfo WHERE username = ?";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // If username exists, check password
        if ($result->num_rows > 0) {
            // Fetch the user's data
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Correct login
                session_start();
                $_SESSION['username'] = $user['username'];  // Store username in session
                header("Location: dashboard.php");  // Redirect to the dashboard page
                exit();
            } else {
                // Invalid password
                $login_error = "Invalid username or password.";
            }
        } else {
            // Username does not exist
            $login_error = "Invalid username or password.";
        }

        // Close the statement
        $stmt->close();
    } else {
        $login_error = "Error executing query: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1a1a1a; /* Dark background for a classy look */
            color: #f0f0f0; /* Light text for contrast */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 450px;
            margin: auto;
            padding: 30px;
            background-color: #2c2c2c; /* Darker gray for the form */
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s;
        }

        .container:hover {
            transform: scale(1.02); /* Slight zoom effect on hover */
        }

        .title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffcc00; /* Gold color for the title */
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #ffcc00; /* Gold color for labels */
        }

        .input-container {
            margin-bottom: 15px;
            border: 1px solid #ffcc00; /* Gold border for input boxes */
            border-radius: 6px;
            background-color: #444; /* Slightly lighter gray for input background */
            overflow: hidden; /* Ensures the border radius is applied */
        }

        input {
            padding: 12px;
            border: none; /* Remove default border */
            width: 100%; /* Full width */
            color: #fff; /* White text in inputs */
            background-color: transparent; /* Transparent background to show the container */
            font-size: 16px; /* Font size for inputs */
        }

        input:focus {
            outline: none;
            border-color: #ff9900; /* Brighter gold on focus */
        }

        button {
            padding: 12px;
            background-color: #ffcc00; /* Gold button for contrast */
            color: #000; /* Black text on button */
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #e6b800; /* Darker gold on hover */
            transform: translateY(-2px); /* Lift effect on hover */
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer-text a {
            color: #ffcc00; /* Gold link for contrast */
            text-decoration: none;
            transition: text-decoration 0.3s;
        }

        .footer-text a:hover {
            text-decoration: underline; /* Underline on hover for links */
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Login to Your Account</h1>
        <form class="login-form" action="login.php" method="POST" aria-label="Login Form">
            <label for="username">Username:</label>
            <div class="input-container">
                <input type="text" id="username" name="username" required aria-required="true">
            </div>

            <label for="password">Password:</label>
            <div class="input-container">
                <input type="password" id="password" name="password" required aria-required="true">
            </div>

            <button type="submit">Login</button>
            <p class="footer-text">Don't have an account? 
                <a href="signup.php">Sign Up Here</a>
            </p>
        </form>

        <?php if ($login_error != ""): ?>
            <p class="error-message"><?php echo $login_error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
