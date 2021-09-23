<?php
  if(!isset($page_title)) { $page_title = 'Artifacts'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VW7XFDFLF9"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-VW7XFDFLF9');
    </script>

    <!-- Remainder of head -->
    <title>Artifacts - <?php echo h($page_title); ?></title>
    <link rel="shortcut icon" type="image/jpg" href="<?php echo url_for('images/favicon.ico') ?>">
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="../../stylesheets/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <?php if($page_title == 'Create Use') {
        echo '<script src="' . url_for('/js/public.js') . '"></script>';
      }?>
  </head>

  <body>
    <header>
      <a class="header-link" href="/index.php"><h1>Artifact Management Tool</h1></a>
    </header>
            <?php
              $username = $_SESSION['username'] ?? '';
              $_SESSION['user_group'] = $_SESSION['user_group'] ?? '';
              if($_SESSION['user_group'] == 2) {
                echo '<navigation>';
                echo '<ul>';
                echo '<li>';
                $menu = '<a href="' . url_for('index.php') . '">Menu</a>&ensp;<a href="' . url_for('logout.php') . '">Logout</a></li>';
                echo '<li>Admin: ' . $username . ' ';
                echo $menu;
                echo '</ul>';
                echo '</navigation>';
              } elseif($_SESSION['user_group'] == 1) {
                echo '<navigation>';
                echo '<ul>';
                echo '<li>';
                $menu = '<a href="' . url_for('index.php') . '">Menu</a>&ensp;<a href="' . url_for('logout.php') . '">Logout</a></li>';
                echo '<li>User: ' . $username . '&ensp;';
                echo $menu;
                echo '</ul>';
                echo '</navigation>';
              }
            ?>

      <?php echo display_session_message(); ?>
