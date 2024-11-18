<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "duplicate";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM dupe WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Fetch the password hash
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            echo "Login successful!";
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Account not found. Please sign up.";
    }

    // Close the statement and connection
    $stmt->close();
}
$conn->close();
?>
