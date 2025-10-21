<?php
$peopleFile = 'people.json';
$people = [];
if (file_exists($peopleFile)) {
    $jsonData = file_get_contents($peopleFile);
    $people = json_decode($jsonData, true) ?? [];
}
?>
<h2>Elenco Persone</h2>
<a href="add_person.php">➕ Aggiungi Persona</a>
<br><br>
<?php if (empty($people)): ?>
    <p>Nessuna persona trovata.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Azioni</th>
        </tr>
        <?php foreach ($people as $p): ?>
            <tr>
                <td><?php echo htmlspecialchars($p['id']); ?></td>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td><?php echo htmlspecialchars($p['email']); ?></td>
                <td>
                    <a href="edit_person.php?id=<?php echo urlencode($p['id']); ?>">✏️ Modifica</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
