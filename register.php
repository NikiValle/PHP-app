<?php
require_once 'functions.php';
$errors = [];
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_username($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? ''; 
    if ($username === '') {
        $errors[] = "Username vuoto o contiene caratteri non ammessi.";
    }
    if (!valid_password($password)) {
        $errors[] = "Password troppo corta (minimo 6 caratteri).";
    }
    if ($password !== $password2) {
        $errors[] = "Le password non coincidono.";
    }
    if (empty($errors)) {
        $users = read_users();
        if (isset($users[$username])) {
            $errors[] = "Username già registrato.";
        } else {
            $users[$username] = [
                'password' => $password,
                'created_at' => date('c')
            ];            
            if (save_users($users)) {
                $success = "Registrazione avvenuta con successo. Puoi ora effettuare il login.";
            } else {
                $errors[] = "Errore salvataggio utente. Controlla permessi file.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title>Registrazione</title>
</head>
<body>
  <h1>Registrazione</h1>
  <?php if ($errors): ?>
    <div class="errors">
      <ul>
        <?php foreach ($errors as $e): ?><li><?php echo htmlspecialchars($e); ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="success"><?php echo htmlspecialchars($success); ?></div>
  <?php endif; ?>
  <form method="post" action="register.php" autocomplete="off">
    <label>Username
      <input type="text" name="username" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <label>Conferma Password
      <input type="password" name="password2" required>
    </label>
    <button type="submit">Registrati</button>
  </form>
  <p>Hai già un account? <a href="login.php">Accedi</a></p>
</body>
</html>
