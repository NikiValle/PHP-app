<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM persone WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "<p>Persona eliminata con successo.</p>";
} else {
    echo "<p>Errore durante l'eliminazione.</p>";
}
?>
<a href="view_people.php">Torna all'elenco</a>
