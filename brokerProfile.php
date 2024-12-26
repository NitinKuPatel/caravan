<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: brokerProfile.php"); // Redirect to login if not logged in
    exit();
}

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

// Get user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT Username, Adhaar, Pan, Email, Mobile, Address FROM broker WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user data
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User  not found.";
    exit();
}

// Fetch all carriers
$carrier_stmt = $conn->prepare("SELECT Username, Mobile, Email FROM carrier");
$carrier_stmt->execute();
$carrier_result = $carrier_stmt->get_result();

// Close the statements
$stmt->close();
$carrier_stmt->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="Style.css">
    <style>
          #profile{
            width:200px:
            height:500px;
            border-radius:10%;
            background-color: rgb(214, 210, 215);
            Padding:20px; 
            Margin-left:25%;  
        }
        strong{
            color: rgb(35, 4, 58);
            font:25px;
        }
        p{
            color: rgb(41, 4, 75);
            font:25px;
            margin-bottom:30px;
            line: spacing 5px;
        }
        footer{
            marin-top:50px;
        }
        thead{
            background-color:rgb(156, 104, 6);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead, td {
            padding: 10px;
            text-align: left;
        }
        tr:hover {
            background-color:red; /* Hover effect */
        }
        /* Hide borders */
        table, thead, td {
            border: none;
        }
    </style>
</head>
<body>
<nav id="container">
        <img id="img1" src="images/CVN.jpg" alt="logo">
        <a href="caravan.html"><div id="Login">Home</div></a>
        <a href="carrierLogin.html"><div id="Login">Logout</div></a>
    </nav>
    <div id=profile style="width:500px">
    <h1>Welcome, <?php echo htmlspecialchars($user['Username']); ?>!</h1>
    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['Username']); ?></p>
    <p><strong>Adhaar No:</strong> <?php echo htmlspecialchars($user['Adhaar']); ?></p>
    <p><strong>Pan Card:</strong> <?php echo htmlspecialchars($user['Pan']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
    <p><strong>Mobile No:</strong> <?php echo htmlspecialchars($user['Mobile']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['Address']); ?></p>
    </div><br><br><br>
    <h2>Carrier Contacts</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($carrier = $carrier_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($carrier['Username']); ?></td>
                    <td><?php echo htmlspecialchars($carrier['Mobile']); ?></td>
                    <td><?php echo htmlspecialchars($carrier['Email']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    
</body>
<footer>
        <br><br><br><br>
        <hr><br><br><br>
        <p>&copy;2024 Freight Company and anomalous &dot; Privacy Policy</p>
        <p>The Caravan Platform is owned and operated by anomalous .</ ```php
        <p>All rights reserved.</p>
    </footer>

</html>