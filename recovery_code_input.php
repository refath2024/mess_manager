<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Recovery Code</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Enter Recovery Code</h1>
        <form action="verify_recovery_code.php" method="post">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <input type="text" name="recovery_code" placeholder="Enter your recovery code" required>
            <button type="submit">Verify Code</button>
        </form>
    </div>
</body>
</html>