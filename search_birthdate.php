<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $stmt = $conn->prepare("SELECT * FROM persone WHERE data_nascita > ?");
    $stmt->bind_param("s", $data);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Persone nate dopo $data</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "{$row['nome']} {$row['cognome']} - {$row['data_nascita']}<br>";
    }
}
?>
<h2>Ricerca per Data di Nascita</h2>
<form method="post">
    Mostra persone nate dopo: <input type="date" name="data" required>
    <button type="submit">Cerca</button>
</form>
