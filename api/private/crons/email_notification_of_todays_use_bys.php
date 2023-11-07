<?php 
    file_put_contents(
        __FILE__ . '.log', 
        __FILE__ . ' began running at ' . date('Y-m-d G:i:s') . "\n",
        FILE_APPEND
    );
    require_once('/var/www/artifact-management-tool/private/initialize.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $interval = DEFAULT_USE_INTERVAL;
    $sweetSpot = '';
    $minimumAge = 0;
    $shelfSort = 'no';
    include(SHARED_PATH . '/artifact_type_array.php'); 
    global $typesArray;
    $type = $typesArray;

    $users = query("SELECT id FROM users");

    foreach ($users as $user) {
        
        $artifact_set = use_by($type, $interval, $sweetSpot, $minimumAge, $shelfSort, $user['id']);

        $due_today = array();

        $i = 0;
        while($artifact = mysqli_fetch_assoc($artifact_set)) { 
            
            date_default_timezone_set('America/New_York');
            $DateTimeNow = new DateTime(date('Y-m-d')); 
            $DateTimeMostRecentUse = new DateTime(substr($artifact['MostRecentUseOrResponse'],0,10)); 
            $date_of_most_recent_use = $DateTimeMostRecentUse->format('Y-m-d');
            $DateTimeAcquisition = new DateTime(substr($artifact['Acq'],0,10)); 
            $intervalInHours = $interval * 24;
    
            if ($DateTimeMostRecentUse < $DateTimeAcquisition || $artifact['MostRecentUseOrResponse'] === NULL) {
                $DateInterval = DateInterval::createFromDateString("$intervalInHours hour");
                $useByDate = date_add($DateTimeAcquisition, $DateInterval);
            } else {
                $doubledInterval = $intervalInHours * 2;
                $DateInterval = DateInterval::createFromDateString("$doubledInterval hour");
                $useByDate = date_add($DateTimeMostRecentUse, $DateInterval);
            }
    
            if ($useByDate->format('Y-m-d') === $DateTimeNow->format('Y-m-d')) {
                $due_today[$i]['artifact'] = h($artifact['Title']);
                $due_today[$i]['most_recent_use'] = $date_of_most_recent_use;
            }
            $i++;
        }
    
        if(count($due_today) > 0) { // email this list to the user

            // get user email address
            $email = singleValueQuery("SELECT email FROM users WHERE id = '" . $user['id'] . "'");

            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();                                   //Send using SMTP
            $mail->Host       = 'smtp.sendgrid.net';           //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                          //Enable SMTP authentication
            $mail->Username   = 'apikey';                      //SMTP username
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption
            $mail->Password   = SENDGRID_API_KEY;              //SMTP password 
            $mail->Port       = 465;                           //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            // Recipients
            $mail->setFrom(SENDGRID_FROM_EMAIL, DEV_NAME);
            $mail->addAddress($email);
            $mail->addReplyTo(DEV_EMAIL, DEV_NAME);
   
            // Content
            $mail->isHTML(true);

            try {
                $mail->Subject = "Artifact Uses Due Today";
                $body = '
                    <ul>
                ';

                foreach($due_today as $artifact) {
                    $name = $artifact['artifact'];
                    $most_recent_use = $artifact['most_recent_use'];
                    $body .= "
                        <li>
                            $name: last used $most_recent_use
                        </li>
                    ";
                }

                $body .= '
                    </ul>
                    <p>These artifacts have a use by date of today.</p>
                ';

                $mail->Body = $body;

                $mail_result = $mail->send();
                file_put_contents(__FILE__ . '.log', 
                    print_r($mail_result, true) . "\n"
                    . "Email use by list sent to $email\n", 
                    FILE_APPEND
                );

             } catch (Exception $Exception) {
                file_put_contents(__FILE__ . '.log', 
                    'Email exception caught at ' . $currentDate->format('Y-m-d H:i:s') . "\n"
                    . print_r($Exception, true) . "\n", 
                    FILE_APPEND
                );

                try {
                    $mail->Subject = "Error with Artifact Uses Due Today Email";
                    $mail->Body = '<p>The following Exception was thrown when trying to email a use by list:</p>
                        <pre>' . print_r($Exception, true) . '</pre>
                    ';
                    $mail->send();
    
                } catch (Exception $Exception) {
                    file_put_contents(__FILE__ . '.log', 
                        'Email exception caught in email notification to dev of error at ' 
                        . $currentDate->format('Y-m-d H:i:s') . "\n"
                        . print_r($Exception, true) . "\n", 
                        FILE_APPEND
                    );
                }
                // email dev notice of exception


             }
            
        };
    }

    file_put_contents(
        __FILE__ . '.log', 
        __FILE__ . ' finished running at ' . date('Y-m-d G:i:s') . "\n",
        FILE_APPEND
    );

?>