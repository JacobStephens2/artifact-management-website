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
        <a href="<?php echo url_for('/artifacts/index.php');?>">
          Artifacts
        </a>
      </li>

      <ul class="list-2">
        <li>
          <a class="action" href="<?php echo url_for('/artifacts/new.php'); ?>">
            Create New Artifact
          </a>
        </li>
        
        <li><a href="<?php echo url_for('/users/index.php');?>">
          Users
          </a>
        </li>
        <li>
          <a class="action" href="<?php echo url_for('/users/new.php'); ?>">
            Add New User
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/artifacts/responses.php');?>">
            Uses
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/uses/create.php');?>">
            Record Use
          </a>
        </li>
        <li>
          <a href=" <?php echo url_for('/artifacts/useby.php');?>">
            Use Artifacts by Date List
          </a>
        </li>
        <li>
          <a href="<?php echo url_for('/artifacts/playgroup.php');?>">
            User Group
          </a>
        </li>
        <li>
          <a class="action" href="<?php echo url_for('/artifacts/playgroup-choose.php'); ?>">
            Choose Games for User Group
          </a>
        </li>
        <li>
          <a href=" <?php echo url_for('/explore/index.php');?>">
            Explore Artifacts by Characteristic
          </a>
        </li>
      </ul>

      <li class="main-menu"><a href="<?php echo url_for('/archive.php'); ?>">Archived Pages</a></li>
      <li 
        class="main-menu" 
        style="margin-top: 0.5rem"
        >
        <a href="<?php echo url_for('/reset/index.php'); ?>">Reset password</a>
      </li>

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
