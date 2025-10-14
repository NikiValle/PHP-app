<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM persone WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$persona = $stmt->get_result()->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data_nascita = $_POST['data_nascita'];
    $update = $conn->prepare("UPDATE persone SET nome=?, cognome=?, data_nascita=? WHERE id=?");
    $update->bind_param("sssi", $nome, $cognome, $data_nascita, $id);
    if ($update->execute()) {
        echo "<p>Dati aggiornati con successo!</p>";
    } else {
        echo "<p>Errore nell'aggiornamento.</p>";
    }
}
?>
<h2>Modifica Persona</h2>
<form method="post">
    Nome: <input type="text" name="nome" value="<?= $persona['nome'] ?>" required><br>
    Cognome: <input type="text" name="cognome" value="<?= $persona['cognome'] ?>" required><br>
    Data di nascita: <input type="date" name="data_nascita" value="<?= $persona['data_nascita'] ?>" required><br>
    <button type="submit">Aggiorna</button>
</form>
