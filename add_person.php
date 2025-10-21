<?php
$peopleFile = 'people.json';
$people = [];
if (file_exists($peopleFile)) {
    $jsonData = file_get_contents($peopleFile);
    $people = json_decode($jsonData, true) ?? [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($name && $email) {
        $newPerson = [
            'id' => uniqid(),
            'name' => $name,
            'email' => $email
        ];
        $people[] = $newPerson;
        file_put_contents($peopleFile, json_encode($people, JSON_PRETTY_PRINT));
        echo "<p>✅ Persona aggiunta con successo!</p>";
        echo '<a href="view_people.php">Torna alla lista</a>';
        exit;
    } else {
        echo "<p style='color:red'>Errore: Nome ed email sono obbligatori.</p>";
    }
}
?>
<h2>Aggiungi Persona</h2>
<form method="post">
    <label>Nome:</label><br>
    <input type="text" name="name" required><br><br>
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit">Aggiungi</button>
</form>
<a href="view_people.php">Torna alla lista</a>
