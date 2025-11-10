<?php
require_once __DIR__ . '/../data/functions.php';

$id = $_GET['id'] ?? null;
$record = $id ? record_find($id) : null;
$formats = formats_all();

if (!$record) {
    echo("<p>Record not found.</p>");
    return;
}
?>

<h2>Edit Record</h2>
<form method="POST">
    <label>Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($record['title']) ?>" required>

    <label>Artist</label>
    <input type="text" name="artist" value="<?= htmlspecialchars($record['artist']) ?>" required>

    <label>Price</label>
    $<input type="number" step="0.01" name="price" value="<?= htmlspecialchars($record['price']) ?>" required>

    <label>Formats</label>
    <select name="format_id" required>
        <?php foreach ($formats as $f): ?>
            <option value="<?= $f["id"] ?>"><?= $f["name"] ?></option>
        <?php endforeach; ?>
    </select>

    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?= $record["id"] ?>">
    
    <button type="submit">Save Changes</button>
</form>
<a href="?view=list">Back to List</a>