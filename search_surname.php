<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cognome = $_POST['cognome'];
    $stmt = $conn->prepare("SELECT * FROM persone WHERE cognome = ?");
    $stmt->bind_param("s", $cognome);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<h2>Persone con cognome '$cognome'</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "{$row['nome']} {$row['cognome']} - {$row['data_nascita']}<br>";
    }
}
?>
<h2>Ricerca per Cognome</h2>
<form method="post">
    Cognome: <input type="text" name="cognome" required>
    <button type="submit">Cerca</button>
</form>
