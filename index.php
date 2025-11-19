<?php
include __DIR__ . "/data/db.php";
include __DIR__ . "/data/functions.php";

session_start();

$view   = filter_input(INPUT_GET, 'view') ?: 'list';
$action = filter_input(INPUT_POST, 'action');

function require_login(): void
{
  if (empty($_SESSION['user_id'])) {
    header('Location: ?view=login');
    exit;
  }
}

$public_views   = ['login', 'register'];
$public_actions = ['login', 'register'];

if ($action && !in_array($action, $public_actions, true)) {
  require_login();
}

if (!$action && !in_array($view, $public_views, true)) {
  require_login();
}

$view = $_GET['view'] ?? 'list';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $action = $_POST['action'] ?? '';

  switch ($action) {

    case 'create':
      $ok = record_create(
        $_POST['title'],
        $_POST['artist'],
        $_POST['price'],
        $_POST['format_id']
      );
      $view = $ok ? 'created' : 'create';
      break;

    case 'update':
      $ok = record_update(
        $_POST['id'],
        $_POST['title'],
        $_POST['artist'],
        $_POST['price'],
        $_POST['format_id']
      );
      $view = $ok ? 'list' : 'edit';
      break;

    case 'login':
      $username = trim((string)($_POST['username'] ?? ''));
      $password = (string)($_POST['password'] ?? '');

      if ($username && $password) {
        $user = user_find_by_username($username);
        if ($user && password_verify($password, $user['password_hash'])) {
          $_SESSION['user_id'] = (int)$user['id'];
          $_SESSION['full_name'] = $user['full_name'];
          $view = 'list';
        } else {
          $login_error = "Invalid username or password.";
          $view = 'login';
        }
      } else {
        $login_error = "Enter both fields.";
        $view = 'login';
      }
      break;

    case 'logout':
      $_SESSION = [];
      session_destroy();
      session_start();
      $view = 'login';
      break;

    case 'register':
      $username  = trim((string)($_POST['username'] ?? ''));
      $full_name = trim((string)($_POST['full_name'] ?? ''));
      $password  = (string)($_POST['password'] ?? '');
      $confirm   = (string)($_POST['confirm_password'] ?? '');

      if ($username && $full_name && $password && $password === $confirm) {
        $existing = user_find_by_username($username);
        if ($existing) {
          $register_error = "That username already exists.";
          $view = 'register';
        } else {
          $hash = password_hash($password, PASSWORD_DEFAULT);
          user_create($username, $full_name, $hash);

          $user = user_find_by_username($username);
          $_SESSION['user_id'] = (int)$user['id'];
          $_SESSION['full_name'] = $user['full_name'];
          $view = 'list';
        }
      } else {
        $register_error = "Complete all fields and match passwords.";
        $view = 'register';
      }
      break;

    case 'add_to_cart':
      require_login();
      $record_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

      if ($record_id) {
        if (!isset($_SESSION['cart'])) {
          $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = $record_id;
      }
      $view = 'list';
      break;

    case 'checkout':
      require_login();
      $cart_ids = $_SESSION['cart'] ?? [];

      if ($cart_ids) {
        foreach ($cart_ids as $rid) {
          purchase_create((int)$_SESSION['user_id'], (int)$rid);
        }
        $_SESSION['cart'] = [];
      }
      $view = 'checkout_success';
      break;

    default:
      // no action or unknown action
      break;
  }
} else if (($_GET['view'] ?? '') === 'delete' && isset($_GET['id'])) {

  record_delete($_GET['id']);
  $view = 'deleted';
}
if ($view === 'cart') {
  $cart_ids = $_SESSION['cart'] ?? [];
  $records_in_cart = records_by_ids($cart_ids);
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
    if ($view === 'login') {
      include __DIR__ . '/partials/login-form.php';
    } elseif ($view === 'register') {
      include __DIR__ . '/partials/register-form.php';
    } elseif ($view === 'cart') {
      include __DIR__ . '/partials/cart.php';
    } elseif ($view === 'checkout_success') {
      include __DIR__ . '/partials/checkout-success.php';
    } elseif ($view === 'list') {
      include __DIR__ . '/partials/records-list.php';
    } elseif ($view === 'create') {
      include __DIR__ . '/partials/record-form.php';
    } elseif ($view === 'created') {
      include __DIR__ . '/partials/record-created.php';
    } elseif ($view === 'deleted') {
      include __DIR__ . '/partials/record-deleted.php';
    } else echo '<p>Invalid view.</p>';
    ?>
  </main>
</body>

</html>

<!-- warning: source control history might look a little weird, that's because i split my development between my laptop and phone (laptop for offline, phone for online) because my laptop's connection is a little wonky at home -->