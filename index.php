<?php
require_once __DIR__ . '/data/functions.php';

$view = $_GET['view'] ?? 'list';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = ($_POST['action'] ?? '');
  if ($action === 'create') {
    $ok = record_create($_POST['title'], $_POST['artist'], $_POST['price'], $_POST['format_id']);
    $view = $ok ? 'created' : 'create';
  } else if ($action === 'update') {
    $ok = record_update($_POST['id'], $_POST['title'], $_POST['artist'], $_POST['price'], $_POST['format_id']);
    $view = $ok ? 'list' : 'edit';
  }
} else if ((($_GET['view'] ?? '') === 'delete') && (isset($_GET['id']))) {
  record_delete($_GET['id']);
  $view = 'deleted';
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
      elseif ($view === 'edit') include __DIR__ . '/partials/record-edit.php';
      elseif ($view === 'deleted') include __DIR__ . '/partials/record-deleted.php';
      else echo '<p>Invalid view.</p>';
    ?>
  </main>
</body>
</html>

<!-- warning: source control history might look a little weird, that's because i split my development between my laptop and phone (laptop for offline, phone for online) because my laptop's connection is a little wonky at home -->