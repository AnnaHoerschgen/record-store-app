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
    <th colspan="2">Edit and Delete</th>
  </tr>
  <?php foreach ($records as $r): ?>
  <tr>
    <td><?= htmlspecialchars($r['title']) ?></td>
    <td><?= htmlspecialchars($r['artist']) ?></td>
    <td>$<?= htmlspecialchars($r['price']) ?></td>
    <td><?= htmlspecialchars($r['format_name']) ?></td>
    <td><?= htmlspecialchars($r['genre_name']) ?></td>
    <td>
      <a href="?view=edit&id=<?= $r['id'] ?>">Edit</a>
    </td>
    <td>
      <a href="?view=delete&id=<?= $r['id'] ?>" onclick="return confirm('Delete this record?');">Delete</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
