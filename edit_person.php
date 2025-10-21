<?php
$peopleFile = 'people.json';
$people = [];
if (file_exists($peopleFile)) {
    $jsonData = file_get_contents($peopleFile);
    $people = json_decode($jsonData, true) ?? [];
}
$id = $_GET['id'] ?? '';
$personIndex = null;
$person = null;
foreach ($people as $index => $p) {
    if ($p['id'] === $id) {
        $personIndex = $index;
        $person = $p;
        break;
    }
}
if (!$person) {
    echo "<p style='color:red'>Persona non trovata.</p>";
    echo '<a href="view_people.php">Torna alla lista</a>';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($name && $email) {
        $people[$personIndex]['name'] = $name;
        $people[$personIndex]['email'] = $email;
        file_put_contents($peopleFile, json_encode($people, JSON_PRETTY_PRINT));
        echo "<p>✅ Persona modificata con successo!</p>";
        echo '<a href="view_people.php">Torna alla lista</a>';
        exit;
    } else {
        echo "<p style='color:red'>Errore: Nome ed email sono obbligatori.</p>";
    }
}
?>
<h2>Modifica Persona</h2>
<form method="post">
    <label>Nome:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($person['name']); ?>" required><br><br>
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($person['email']); ?>" required><br><br>
    <button type="submit">Salva Modifiche</button>
</form>
<a href="view_people.php">Torna alla lista</a>
