<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reset_code = $_POST['reset_code'];
    $new_password = $_POST['new_password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'caravan');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verify the reset code
    $stmt = $conn->prepare("SELECT * FROM broker WHERE reset_code = ?");
    $stmt->bind_param("s", $reset_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Update the password and clear the reset code
        $stmt = $conn->prepare("UPDATE broker SET Password = ?, reset_code = NULL WHERE id = ?");
        $stmt->bind_param("si", $new_password, $user['id']);
        $stmt->execute();

        echo "Password updated successfully. You can now log in.";
    } else {
        echo "Invalid reset code.";
    }

    $conn->close();
}
?>
