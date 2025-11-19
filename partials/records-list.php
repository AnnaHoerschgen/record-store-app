<?php
require_once __DIR__ . '/../data/functions.php';
$records = records_all();
?>
<h2>All Records</h2>
<table>
  <tr>
    <th>Title</th>
    <th>Artist</th>
    <th>Price</th>
    <th>Format</th>
    <th>Genre</th>
    <th>Operations</th>
  </tr>
  <?php foreach ($records as $r): ?>
    <tr>
      <td><?= htmlspecialchars($r['title']) ?></td>
      <td><?= htmlspecialchars($r['artist']) ?></td>
      <td>$<?= htmlspecialchars($r['price']) ?></td>
      <td><?= strtoupper(htmlspecialchars($r['format_name'])) ?></td>
      <td><?= htmlspecialchars($r['genre_name']) ?></td>
      <td class="operations-cell">
        <form method="post" class="d-inline">
          <input type="hidden" name="id" value="<?= $r['id'] ?>">
          <input type="hidden" name="action" value="add_to_cart">
          <button class="btn btn-sm btn-outline-success">Add to Cart</button>
        </form>

        <form method="post" class="d-inline">
          <input type="hidden" name="id" value="<?= $r['id'] ?>">
          <input type="hidden" name="action" value="edit">
          <button class="btn btn-sm btn-outline-success">Edit</button>
        </form>

        <form method="post" class="d-inline" onsubmit="return confirm('Delete this record?');">
          <input type="hidden" name="id" value="<?= $r['id'] ?>">
          <input type="hidden" name="action" value="delete">
          <button class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>