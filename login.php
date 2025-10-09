<?php
require_once 'functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_username($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $errors[] = "Inserisci username e password.";
    } else {
        $users = read_users();
        if (!isset($users[$username])) {
            $errors[] = "Username non trovato.";
        } else {
            $stored_password = $users[$username]['password'] ?? '';
                if ($password === $stored_password) {
                session_regenerate_id(true);
                $_SESSION['username'] = $username;
                $_SESSION['logged_at'] = time();
                redirect('dashboard.php');
            } else {
                $errors[] = "Password errata.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="it">
<head>
  <title>Login</title>
</head>
<body>
  <h1>Login</h1>
  <form method="post" action="login.php" autocomplete="off">
    <label>Username
      <input type="text" name="username" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <button type="submit">Accedi</button>
  </form>
  <p>Non hai un account? <a href="register.php">Registrati</a></p>
</body>
</html>
