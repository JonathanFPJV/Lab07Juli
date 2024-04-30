<?php
// Start session
session_start();

// Dummy user data (replace with database query in a real application)
$pdo = new PDO(
    'mysql:host=localhost;dbname=mydatabase',
    'root',
    '' );

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
    // Query the database to fetch user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();


    // Verify user credentials
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['username'] = $username;
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid username or password
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Estilos/ejemplo02.css"> <!-- Enlaza tu archivo CSS aquí -->
</head>
<body>
    <div class="container"> <!-- Contenedor para centrar el contenido -->
        <h2>Login</h2>
        <?= isset($error) ? "<p class='error-message'>$error</p>" : "" ?>
        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Login">
        </form>
    </div> <!-- Fin del contenedor -->
</body>
</html>

