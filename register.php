<?php
require_once 'functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $errors[] = "Compila tutti i campi.";
    } else {
        $users = read_users();
        if (isset($users[$username])) {
            $errors[] = "Username già registrato.";
        } else {
            $users[$username] = ['password' => password_hash($password, PASSWORD_DEFAULT)];
            save_users($users);
            redirect('login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head><meta charset="UTF-8"><title>Registrazione</title></head>
<body>
<h1>Registrazione</h1>
<?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>
<form method="post">
    <label>Username: <input type="text" name="username" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Registrati</button>
</form>
<p>Hai già un account? <a href="login.php">Accedi</a></p>
</body>
</html>
