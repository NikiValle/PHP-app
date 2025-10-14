<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codice_fiscale = $_POST['codice_fiscale'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data_nascita = $_POST['data_nascita'];
    $stmt = $conn->prepare("INSERT INTO persone (codice_fiscale, nome, cognome, data_nascita) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $codice_fiscale, $nome, $cognome, $data_nascita);
    if ($stmt->execute()) {
        echo "<p>Persona aggiunta con successo!</p>";
    } else {
        echo "<p>Errore: " . $stmt->error . "</p>";
    }
}
?>
<h2>Aggiungi Persona</h2>
<form method="post">
    Codice Fiscale: <input type="text" name="codice_fiscale" required><br>
    Nome: <input type="text" name="nome" required><br>
    Cognome: <input type="text" name="cognome" required><br>
    Data di nascita: <input type="date" name="data_nascita" required><br>
    <button type="submit">Aggiungi</button>
</form>
