<?php 
require_once('../private/initialize.php');
require_login();
$page_title = 'Menu';
include(SHARED_PATH . '/header.php');
?>

<main>
  <div id="main-menu">

    <h1>Main Menu</h1>

    <!-- Artifacts -->
    <ul>
      <li>
        <a href="<?php echo url_for('/artifacts/index.php');?>">
          Artifacts
        </a>
      </li>

      <ul>
        <li>
          <a class="action" href="<?php echo url_for('/artifacts/new.php'); ?>">
            Create New Artifact
          </a>
        </li>
        <li>
          <a href=" <?php echo url_for('/artifacts/useby.php');?>">
            Use Artifacts by Date List
          </a>
        </li>

        <li>
          <a href=" <?php echo url_for('/explore/index.php');?>">
            Explore Artifacts by Characteristic
          </a>
        </li>

        <li>
          <a href="<?php echo url_for('/explore/uses-by-artifact.php'); ?>">
            Uses By Artifact
          </a>
        </li>
      </ul>
    </ul>

    <!-- Uses -->
    <ul>
      <li>
        <a href="<?php echo url_for('/uses/index.php');?>">
          Uses
        </a>
      </li>

      <ul>
        <li>
          <a href="<?php echo url_for('/uses/create.php');?>">
            Record Use
          </a>
        </li>
      </ul>
    </ul>

    <!-- Users -->
    <ul>
      <li><a href="<?php echo url_for('/users/index.php');?>">
        Users
        </a>
      </li>

      <ul>
        <li>
          <a class="action" href="<?php echo url_for('/users/new.php'); ?>">
            Add New User
          </a>
        </li>

        <li>
          <a href="<?php echo url_for('/playgroup/index.php');?>">
            User Group
          </a>
        </li>

        <li>
          <a class="action" href="<?php echo url_for('/playgroup/choose.php'); ?>">
            Choose Artifacts for User Group
          </a>
        </li>
      </ul>
    </ul>

    <ul>
      <li class="main-menu"><a href="<?php echo url_for('/archive.php'); ?>">Archived Pages</a></li>
    </ul>
    
    <ul>
      <li>
        <a href="<?php echo url_for('/settings/edit.php'); ?>">
          Settings
        </a>
      </li>
      <li class="main-menu">
        <a href="<?php echo url_for('/reset-password/index.php'); ?>">Reset password</a>
      </li>
    </ul>

    <p>
      You can use this site to generate a list of use-by dates for objects. 
      <a href="https://jacobstephens.net" target="_blank">Jacob Stephens</a> 
      uses this tool to track usage of books, games, movies, equipment, and more, ensuring use for each 
      either in the next or previous 90 days. 
      <a href="https://www.theminimalists.com/ninety/" target="_blank">The Minimalists' 90/90 Rule</a> 
      inspired Jacob to create this&nbsp;tool.
    </p>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
