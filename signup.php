<?php
// Include the database connection
require 'db_connection.php';

// Initialize variables
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert the user data into the database
    $query = "INSERT INTO users (username, address, email, phone, password) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters to the SQL query
        $stmt->bind_param("sssss", $username, $address, $email, $phone, $hashed_password);

        // Execute the query
        if ($stmt->execute()) {
            $success_message = "User registered successfully!";
        } else {
            $success_message = "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $success_message = "Error preparing the statement: " . $conn->error;
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
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1a1a1a; /* Dark background for a classy look */
            color: #f0f0f0; /* Light text for contrast */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px; /* Increased width for larger sign-up form */
            margin: auto;
            padding: 40px;
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

        .signup-form {
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

        /* Popup Styles */
        .popup {
            display: none; /* Hidden by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #333;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
            width: 300px; /* Smaller width for popup */
            text-align: center;
        }

        .popup.show {
            display: block; /* Show the popup */
        }

        .popup button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #ffcc00;
            border: none;
            color: #000;
            font-size: 16px;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Create Your Account</h1>
        <form class="signup-form" action="signup.php" method="POST" aria-label="Sign Up Form">
            <label for="username">Username:</label>
            <div class="input-container">
                <input type="text" id="username" name="username" required aria-required="true">
            </div>

            <label for="address">Address:</label>
            <div class="input-container">
                <input type="text" id="address" name="address" required aria-required="true">
            </div>

            <label for="email">Email:</label>
            <div class="input-container">
                <input type="email" id="email" name="email" required aria-required="true">
            </div>

            <label for="phone">Phone Number:</label>
            <div class="input-container">
                <input type="tel" id="phone" name="phone" required aria-required="true">
            </div>

            <label for="password">Password:</label>
            <div class="input-container">
                <input type="password" id="password" name="password" required aria-required="true">
            </div>

            <button type="submit">Sign Up</button>
            <p class="footer-text">Already have an account? 
                <a href="login.php">Login Here</a>
            </p>
        </form>
    </div>

    <!-- Success Popup -->
    <div class="popup <?php if ($success_message != "") echo 'show'; ?>">
        <p><?php echo $success_message; ?></p>
        <button onclick="window.location.href='login.php';">Go to Login</button>
    </div>

</body>
</html>
