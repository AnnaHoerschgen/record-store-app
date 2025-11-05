<?php
require_once __DIR__ . '/data/functions.php';

$view = $_GET['view'] ?? 'list';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create') {
    $ok = record_create($_POST['title'], $_POST['artist'], $_POST['price'], $_POST['format_id']);
    $view = $ok ? 'created' : 'create';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Record Store</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <?php include __DIR__ . '/components/nav.php'; ?>
  <main>
    <?php
      if ($view === 'list') include __DIR__ . '/partials/records-list.php';
      elseif ($view === 'create') include __DIR__ . '/partials/record-form.php';
      elseif ($view === 'created') include __DIR__ . '/partials/record-created.php';
      else echo '<p>Invalid view.</p>';
    ?>
  </main>
</body>
</html>
