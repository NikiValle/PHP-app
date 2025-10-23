<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['id'])) {
    echo "<p>ID non specificato.</p>";
    exit();
}
$id = $_GET['id'];
$personsFile = 'people.json';
if (!file_exists($personsFile)) {
    echo "<p>Errore: file delle persone non trovato.</p>";
    exit();
}
$data = json_decode(file_get_contents($personsFile), true);
if (!is_array($data)) {
    echo "<p>Errore: formato del file non valido.</p>";
    exit();
}
$found = false;
foreach ($data as $index => $person) {
    if (isset($person['id']) && $person['id'] === $id) {
        unset($data[$index]);
        $found = true;
        break;
    }
}
if ($found) {
    $data = array_values($data);
    file_put_contents($personsFile, json_encode($data, JSON_PRETTY_PRINT));
    echo "<p>Persona eliminata con successo.</p>";
} else {
    echo "<p>Errore: persona non trovata.</p>";
}
?>
<a href="view_people.php">Torna all'elenco</a>
