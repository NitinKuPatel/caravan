<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="update_password.php" method="POST">
        <label for="reset_code">Enter Reset Code:</label>
        <input type="text" id="reset_code" name="reset_code" required>
        <br><br>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br><br>
        <button type="submit">Update Password</button>
    </form>
</body>
</html>
