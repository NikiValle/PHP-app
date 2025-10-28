<?php
require_once 'functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $users = read_users();
    if (!isset($users[$username])) {
        $errors[] = "Utente non trovato.";
    } elseif (!password_verify($password, $users[$username]['password'])) {
        $errors[] = "Password errata.";
    } else {
        $_SESSION['username'] = $username;
        redirect('dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
<h1>Login</h1>
<?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>
<form method="post">
    <label>Username: <input type="text" name="username" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Accedi</button>
</form>
<p>Non hai un account? <a href="register.php">Registrati</a></p>
</body>
</html>