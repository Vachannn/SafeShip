<?php
// Database configuration
$servername = "localhost"; // Change if necessary
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "duplicate"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['customerName'];
    $email = $_POST['customerEmail'];
    $password = password_hash($_POST['customerPassword'], PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO dupe (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}
$conn->close();
?>

