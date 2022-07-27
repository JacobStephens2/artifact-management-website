<?php require_once('../../artifacts_private/initialize.php'); ?>
<?php require_login(); ?>
<?php $page_title = 'About Use By'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>
  <p><a class="back-link" href="<?php echo url_for('/games/playby.php'); ?>">&laquo; Back to Artifact Use List</a></p>
  <div class="objects listing" style="padding-top: 0;">
    <h1>Details about use by and play by dates</h1>
    <p>The use by date for determined by the two following rules.</p>
    <ul>
      <li class="bullet">If the object has not yet been used, the use by date is 180 days from the acquisition date.</li>
      <li class="bullet">Otherwise, the use by date is 360 days from the most recent use date.</li>
    </ul>
    <p>The list is limited to the 100 nearest use by date objects. Keeping these rules enables kept objects to be used either within the past 180 days or the coming 180 days. This approach is probably best used as a guideline rather than as a strict rule. <a href="https://www.theminimalists.com/ninety/" target='_blank'>The Minimalists' 90/90 Rule</a> inspired Jacob, operator of Steward Goods, to use these rules to track their possessions.</p>
</main>

