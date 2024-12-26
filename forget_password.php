<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form action="send_reset_code.php" method="POST">
        <label for="email">Enter your Email:</label>
        <input type="text" id="email" name="Email" required>
        <br><br>
        <button type="submit">Send Reset Code</button>
    </form>
</body>
</html>
