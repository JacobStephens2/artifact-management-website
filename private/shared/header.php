<?php if ( ! isset($page_title) ) { $page_title = 'Artifact Manager'; } ?>

<!DOCTYPE html>

<html lang="en">
  <head>
    
    <title>
      <?php echo h($page_title); ?> - Artifact Manager
    </title>

    <meta charset="utf-8">
    
    <link rel="shortcut icon" type="image/jpg" href="<?php echo url_for('favicon.ico') ?>">

    <link rel="stylesheet" media="all" href="../../style.css" />

    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">

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
      <a class="header-link" href="/index.php">Artifact Manager</a>
    </header>

    <nav class="hideOnPrint">
        <?php
        if(isset($_SESSION['logged_in']) && isset($_SESSION['FullName'])) {
          ?>
          <a href="<?php echo url_for('/settings/edit.php'); ?>">
            <?php echo '<span>' . $_SESSION['username'] . '</span>'; ?>
          </a>
          <?php
        }

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
          ?>
          
          <a href="<?php echo url_for('/artifacts/useby.php'); ?>">
            Use&nbsp;Artifacts&nbsp;By&nbsp;Date
          </a>
          
          <a href="<?php echo url_for('/uses/1-n-uses.php'); ?>">
            Uses
          </a>
          
          <a href="<?php echo url_for('/uses/1-n-new.php'); ?>">
            Record&nbsp;Use
          </a>

          <a href="<?php echo url_for('/artifacts/index.php'); ?>">
            Artifacts
          </a>
        
          <a href="<?php echo url_for('/artifacts/new.php'); ?>">
            Create&nbsp;Artifact
          </a>

          <a href="<?php echo url_for('/users/index.php'); ?>">
            Users
          </a>

          <a href="<?php echo url_for('/users/new.php'); ?>">
            Create&nbsp;User
          </a>
         
          <a href="<?php echo url_for('/types'); ?>">
            Types
          </a>

          <a href="<?php echo url_for('/support.php'); ?>">
            Support
          </a>

          <?php
          echo '<span><a href="' . url_for('logout.php') . '">Logout</a></span>';

        }
      ?>
        
    </nav>

    <?php echo display_session_message(); ?>