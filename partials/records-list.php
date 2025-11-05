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
  </tr>
  <?php foreach ($records as $r): ?>
  <tr>
    <td><?= htmlspecialchars($r['title']) ?></td>
    <td><?= htmlspecialchars($r['artist']) ?></td>
    <td>$<?= htmlspecialchars($r['price']) ?></td>
    <td><?= htmlspecialchars($r['format_name']) ?></td>
    <td><?= htmlspecialchars($r['genre_name']) ?></td>
  </tr>
  <?php endforeach; ?>
</table>
