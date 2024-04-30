<?php
// Start session
session_start();

// Database connection
$pdo = new PDO(
    'mysql:host=localhost;dbname=mydatabase',
    'root',
    ''
);

// Function to validate user input
function validateInput($data) {
    // Remove leading and trailing whitespaces
    $data = trim($data);
    // Convert special characters to HTML entities to prevent XSS attacks
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username and password
    $username = validateInput($_POST['username']);
    $password = validateInput($_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $error = "El nombre de usuario ya está en uso.";
    } else {
        // Insert new user into the database
        $insertStmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insertStmt->execute([$username, $hashedPassword]);
        
        // Set session variables
        $_SESSION['username'] = $username;
        // Redirect to dashboard or any other page
        header("Location: registro_exitoso.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h2>Registro</h2>
    <?php if(isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Nombre de usuario:</label><br>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
