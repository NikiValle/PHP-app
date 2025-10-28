<?php
require_once 'functions.php';
require_login();
$people = read_people();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $cf = sanitize($_POST['cf']);
    $nome = sanitize($_POST['nome']);
    $cognome = sanitize($_POST['cognome']);
    $nascita = $_POST['nascita'];

    if ($cf && $nome && $cognome && $nascita) {
        $people[] = [
            'id' => uniqid(),
            'cf' => $cf,
            'nome' => $nome,
            'cognome' => $cognome,
            'nascita' => $nascita
        ];
        save_people($people);
        redirect('dashboard.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $people = array_values(array_filter($people, fn($p) => $p['id'] !== $id));
    save_people($people);
    redirect('dashboard.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    foreach ($people as &$p) {
        if ($p['id'] === $_POST['id']) {
            $p['cf'] = sanitize($_POST['cf']);
            $p['nome'] = sanitize($_POST['nome']);
            $p['cognome'] = sanitize($_POST['cognome']);
            $p['nascita'] = $_POST['nascita'];
        }
    }
    save_people($people);
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="it">
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body>
<h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
<p><a href="logout.php">Logout</a></p>
<h2>Aggiungi persona</h2>
<form method="post">
    <input type="text" name="cf" placeholder="Codice fiscale" required>
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="text" name="cognome" placeholder="Cognome" required>
    <input type="date" name="nascita" required>
    <button name="add">Aggiungi</button>
</form>
<hr>
<h2>Elenco persone</h2>
<table border="1" cellpadding="5">
<tr><th>CF</th><th>Nome</th><th>Cognome</th><th>Nascita</th><th>Azioni</th></tr>
<?php foreach ($people as $p): ?>
<tr>
<form method="post">
    <td><input name="cf" value="<?= htmlspecialchars($p['cf']); ?>"></td>
    <td><input name="nome" value="<?= htmlspecialchars($p['nome']); ?>"></td>
    <td><input name="cognome" value="<?= htmlspecialchars($p['cognome']); ?>"></td>
    <td><input type="date" name="nascita" value="<?= htmlspecialchars($p['nascita']); ?>"></td>
    <td>
        <input type="hidden" name="id" value="<?= $p['id']; ?>">
        <button name="edit">Modifica</button>
        <button name="delete">Elimina</button>
    </td>
</form>
</tr>
<?php endforeach; ?>
</table>
<hr>
<h2>Filtri</h2>
<h3>Cerca per cognome</h3>
<form method="get">
    <input type="text" name="cognome" placeholder="Cognome">
    <button type="submit">Cerca</button>
</form>
<h3>Cerca per data di nascita</h3>
<form method="get">
    <input type="date" name="data_min">
    <button type="submit">Mostra nati dopo</button>
</form>
<?php
if (isset($_GET['cognome'])) {
    $c = strtolower(trim($_GET['cognome']));
    $ris = array_filter($people, fn($p) => strtolower($p['cognome']) === $c);
    echo "<h4>Risultati per '$c':</h4>";
    foreach ($ris as $r) echo "{$r['nome']} {$r['cognome']} ({$r['nascita']})<br>";
}
if (isset($_GET['data_min'])) {
    $d = $_GET['data_min'];
    $ris = array_filter($people, fn($p) => strtotime($p['nascita']) > strtotime($d));
    echo "<h4>Persone nate dopo $d:</h4>";
    foreach ($ris as $r) echo "{$r['nome']} {$r['cognome']} ({$r['nascita']})<br>";
}
?>
</body>
</html>