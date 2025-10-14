<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$result = $conn->query("SELECT * FROM persone ORDER BY cognome, nome");
echo "<h2>Elenco Persone</h2>";
echo "<table border='1'>
<tr><th>Codice Fiscale</th><th>Nome</th><th>Cognome</th><th>Data Nascita</th><th>Azioni</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['codice_fiscale']}</td>
        <td>{$row['nome']}</td>
        <td>{$row['cognome']}</td>
        <td>{$row['data_nascita']}</td>
        <td>
            <a href='edit_person.php?id={$row['id']}'>Modifica</a> | 
            <a href='delete_person.php?id={$row['id']}'>Elimina</a>
        </td>
    </tr>";
}
echo "</table>";
?>
