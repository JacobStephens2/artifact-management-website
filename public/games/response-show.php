<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php require_login();

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$response = find_response_by_id($id);

?>

<?php $page_title = 'Show use'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <li><a class="back-link" href="<?php echo url_for('/games/responses.php'); ?>">&laquo; Responses</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/playby.php'); ?>">&laquo; Play by list</a></li>
  <li><a class="back-link" href="<?php echo url_for('/uses/create.php'); ?>">&laquo; New response</a></li>
  <li><a class="action" href="<?php echo url_for('/games/response-edit.php?id=' . h(u($response['id']))); ?>">Edit</a></li>

  <div class="use show">

    <div class="attributes">
      <dl>
        <dt>Game: <?php echo h($response['Title']); ?></dt>
      </dl>
      <dl>
        <dt>Date of play: <?php echo h($response['PlayDate']); ?></dt>
      </dl>
      <!-- GET variable approach to passing player id from new page to show -->
      <dl>
          <?php 
            $playerNo = 1;
            echo '<dt>Player ' . $playerNo . ": ";
            $id = $_GET['player1'] ?? '';
            $player = find_player_by_id($id); 
            echo h($player['FirstName']) . ' ' . h($player['LastName']);
            $playerNo++;
            echo "</dt></dl>";
            $id = $_GET['player2'] ?? '';
            if($id != '') {
              $player = find_player_by_id($id); 
              echo "
                <dl>
                  <dt>Player " . $playerNo . ": "
                    .
                      h($player['FirstName']) . ' ' . h($player['LastName']) 
                    .
                  "</dt>
                </dl>";
              $playerNo++;
              $id = $_GET['player3'] ?? '';
              if($id != '') {
                $player = find_player_by_id($id); 
                echo "
                  <dl>
                    <dt>Player " . $playerNo . ": "
                      .
                        h($player['FirstName']) . ' ' . h($player['LastName']) 
                      .
                    "</dt>
                  </dl>";
                $playerNo++;
                $id = $_GET['player' . $playerNo] ?? '';
                if($id != '') {
                  $player = find_player_by_id($id); 
                  echo "
                    <dl>
                      <dt>Player " . $playerNo . ": "
                        .
                          h($player['FirstName']) . ' ' . h($player['LastName']) 
                        .
                      "</dt>
                    </dl>";
                  $playerNo++;
                  $id = $_GET['player5'] ?? '';
                  if($id != '') {
                    $player = find_player_by_id($id); 
                    echo "
                      <dl>
                        <dt>Player " . $playerNo . ": "
                          .
                            h($player['FirstName']) . ' ' . h($player['LastName']) 
                          .
                        "</dt>
                      </dl>";
                    $playerNo++;
                    $id = $_GET['player6'] ?? '';
                    if($id != '') {
                      $player = find_player_by_id($id); 
                      echo "
                        <dl>
                          <dt>Player " . $playerNo . ": "
                            .
                              h($player['FirstName']) . ' ' . h($player['LastName']) 
                            .
                          "</dt>
                        </dl>";
                      $playerNo++;
                      $id = $_GET['player7'] ?? '';
                      if($id != '') {
                        $player = find_player_by_id($id); 
                        echo "
                          <dl>
                            <dt>Player " . $playerNo . ": "
                              .
                                h($player['FirstName']) . ' ' . h($player['LastName']) 
                              .
                            "</dt>
                          </dl>";
                        $playerNo++;
                        $id = $_GET['player8'] ?? '';
                        if($id != '') {
                          $player = find_player_by_id($id); 
                          echo "
                            <dl>
                              <dt>Player " . $playerNo . ": "
                                .
                                  h($player['FirstName']) . ' ' . h($player['LastName']) 
                                .
                              "</dt>
                            </dl>";
                          $playerNo++;
                          $id = $_GET['player9'] ?? '';
                          if($id != '') {
                            $player = find_player_by_id($id); 
                            echo "
                              <dl>
                                <dt>Player " . $playerNo . ": "
                                  .
                                    h($player['FirstName']) . ' ' . h($player['LastName']) 
                                  .
                                "</dt>
                              </dl>";  
                          }
                        }
                      }
                    }      
                  }    
                }  
              }
            }
          ?>
    </div>
    <br />
    <hr />

  </div>


  </div>

</main>
