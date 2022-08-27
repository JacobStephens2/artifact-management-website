<?php if ( ! isset($page_title) ) { $page_title = 'Artifacts'; } ?>

<!DOCTYPE html>

<html lang="en">
  <head>
    
    <title>
      <?php echo h($page_title); ?> - Artifact Management Tool
    </title>

    <meta charset="utf-8">
    
    <link rel="shortcut icon" type="image/jpg" href="<?php echo url_for('favicon.ico') ?>">

    <link rel="stylesheet" media="all" href="../../style.css" />

    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">

    <?php 
      if($page_title == 'Create Use') {
        echo '<script src="' . url_for('/public.js') . '"></script>';
      }
    ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VW7XFDFLF9"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-VW7XFDFLF9');
    </script>

  </head>

  <body>
    <header>
      <a class="header-link" href="/index.php">Artifact Management Tool</a>
    </header>

    <nav class="hideOnPrint">
      <?php
        $username = $_SESSION['username'] ?? '';
        $_SESSION['user_group'] = $_SESSION['user_group'] ?? '';
          if($_SESSION['user_group'] == 2) {
            echo '<span>Admin: ' . $username . '</span>';
          } elseif($_SESSION['user_group'] == 1) {
            echo '<span>User: ' . $username . '</span>';
          }
          if ($_SESSION['logged_in'] == true) {
            echo '<span><a href="' . url_for('index.php') . '">Menu</a></span>';
            echo '<span><a href="' . url_for('logout.php') . '">Logout</a></span>';
            ?>
            <a href="<?php echo url_for('/artifacts/useby.php'); ?>">
              Use Artifacts By Date
            </a>

            <a href="<?php echo url_for('/artifacts/responses.php'); ?>">
              Uses
            </a>
          
            <a href="<?php echo url_for('/uses/create.php'); ?>">
              Record Use
            </a>

            <a href="<?php echo url_for('/artifacts/index.php'); ?>">
              Artifacts
            </a>
          
            <a href="<?php echo url_for('/artifacts/new.php'); ?>">
              Create Artifact
            </a>

            <a href="<?php echo url_for('/users/index.php'); ?>">
              Users
            </a>

            <a href="<?php echo url_for('/users/new.php'); ?>">
              Create User
            </a>

            <a href="<?php echo url_for('/artifacts/aversions.php'); ?>">
              Aversions
            </a>

            <a href="<?php echo url_for('/artifacts/aversion-new.php'); ?>">
              Record Aversion
            </a>

            <?php
          }
      ?>
        
    </nav>

    <?php echo display_session_message(); ?>