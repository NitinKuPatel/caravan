<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: carrierLogin.html"); // Redirect to login page if not logged in
    exit();
}

// Database connection parameters
$servername = "localhost"; // Change if your server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "caravan"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM carrier WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch all brokers
$broker_stmt = $conn->prepare("SELECT id, Username, Mobile FROM broker");
$broker_stmt->execute();
$broker_result = $broker_stmt->get_result();

// Close the statements
$stmt->close();
$broker_stmt->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrier Profile</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        #profile {
            width: 400px;
            height: 500px;
            border-radius: 10%;
            background-color: rgb(214, 210, 215);
            padding: 20px;   
        }
        strong {
            color: rgb(35, 4, 58);
            font-size: 25px;
        }
        p {
            color: rgb(41, 4, 75);
            font-size: 25px;
            margin-bottom: 30px;
            line-height: 5px;
        }
        footer {
            margin-top: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead{
            background-color:rgb(156, 104, 6);
        }
        thead, td {
            padding: 10px;
            text-align: left;
        }
        tr:hover {
            background-color: red; /* Hover effect */
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
    <center>
        <div id="profile" style="width:500px;">
            <h2 style="color:red; font-size:30px;">Welcome, <?php echo htmlspecialchars($user['Username']); ?>!</h2><br><br><br>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['Username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
            <p><strong>Mobile No:</strong> <?php echo htmlspecialchars($user['Mobile']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['Address']); ?></p>
        </div>
    </center>

    <h2>Broker Contacts</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($broker = $broker_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($broker['id']); ?></td>
                    <td><?php echo htmlspecialchars($broker['Username']); ?></td>
                    <td><?php echo htmlspecialchars($broker['Mobile']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <footer>
        <br><br><br><br>
        <hr><br><br><br>
        <p>&copy;2024 Flexport Company and anomalous Tech ALC &dot; Privacy Policy</p>
        <p>The Caravan Platform is owned and operated by Flexport Tech LLC.</ ```php
        <p>All rights reserved.</p>
    </footer>

</body>
</html>