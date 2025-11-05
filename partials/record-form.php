<?php
require_once __DIR__ . '/../data/functions.php';
$formats = formats_all();
?>
<h2>Create a Record</h2>
<form method="POST">
  <label>Title</label>
  <input type="text" name="title" required>
  <label>Artist</label>
  <input type="text" name="artist" required>
  <label>Price</label>
  <input type="number" step="0.01" name="price" required>
  <label>Format</label>
  <select name="format_id" required>
    <option value="">-- Choose Format --</option>
    <?php foreach ($formats as $f): ?>
      <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['name']) ?></option>
    <?php endforeach; ?>
  </select>
  <input type="hidden" name="action" value="create">
  <button type="submit">Save Record</button>
</form>
