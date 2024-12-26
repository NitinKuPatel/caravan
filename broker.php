<?php
// Database configuration
$servername = "localhost"; // Change if your database server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "caravan"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['Username'];
    $adhaar = $_POST['Adhaar'];
    $pan = $_POST['Pan'];
    $email = $_POST['Email'];
    $mobile = $_POST['Mobile'];
    $password = $_POST['Password'];
    $address = $_POST['Address'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO broker (Username, Adhaar, Pan, Email, Mobile, Password, Address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $adhaar, $pan, $email, $mobile, $password, $address);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>