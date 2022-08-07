<?php 
require_once('../artifacts_private/initialize.php');
require_login();
$page_title = 'Menu';
include(SHARED_PATH . '/header.php');
?>

<main>
  <div id="main-menu">

    <h1>Main Menu</h1>

    <ul class="main-menu">
      <li>
        <a href="<?php echo url_for('/games/index.php');?>">
          Artifacts
        </a>
      </li>

      <ul class="list-2">
        <li>
          <a class="action" href="<?php echo url_for('/games/new.php'); ?>">
            Create New Artifact
          </a>
        </li>
        <li><a href="<?php echo url_for('/players/index.php');?>">
          Users
          </a>
        </li>
        <li>
          <a class="action" href="<?php echo url_for('/players/new.php'); ?>">
            Add New User
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/games/responses.php');?>">
            Uses
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/uses/create.php');?>">
            Record Use
          </a>
        </li>
        <li>
          <a href=" <?php echo url_for('/games/playby.php');?>">
            Use Artifacts by Date List
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/games/playgroup.php');?>">
            User Group
          </a>
        </li>
        <li>
          <a class="action" href="<?php echo url_for('/games/playgroup-choose.php'); ?>">
            Choose Games for User Group
          </a>
        </li>
        <li>
          <a href=" <?php echo url_for('/explore/index.php');?>">
            Explore Artifacts by Characteristic
          </a>
        </li>
      </ul>

      <li class="main-menu"><a href="<?php echo url_for('/reset/index.php'); ?>">Reset password</a></li>


      <h2>Archived Menu</h2>

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

    <p>You can use this site to generate a list of use-by dates for objects. 
      <a href="https://jacobstephens.net" target="_blank">Jacob Stephens</a> 
      uses this tool to track usage of their books, ensuring they use each book 
      either in the next or previous 180 days. 
      <a href="https://www.theminimalists.com/ninety/" target="_blank">The Minimalists' 90/90 Rule</a> 
      inspired Jacob to create this tool.</p>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
