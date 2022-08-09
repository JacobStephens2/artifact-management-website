<?php 
require_once('../artifacts_private/initialize.php');
require_login();
$page_title = 'Archive';
include(SHARED_PATH . '/header.php');
?>

<main>
  <div id="main-menu">

      <h1>Archived Pages</h1>

      <li class="main-menu">
        <a href="<?php echo url_for('/objects/index.php'); ?>">
          Objects
        </a>
      </li>

      <ul class="list-2">
        <li>
          <a href="<?php echo url_for('/object_uses/new.php'); ?>">
            Record Object Use
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/object_uses/index.php'); ?>">
            Object Uses
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/objects/useby.php'); ?>">
            Use Objects by Date List
          </a>
        </li>
      </ul>
    </ul>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
