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

    $sweetSpot = '';
    $minimumAge = 0;
    $shelfSort = 'no';
    include(SHARED_PATH . '/artifact_type_array.php'); 
    global $typesArray;
    $type = $typesArray;

    $users = query("SELECT id FROM users");

    foreach ($users as $user) {

        $interval = singleValueQuery("SELECT default_use_interval
            FROM users
            WHERE id = " . $user['id'] . "
        ");
        
        $artifact_set = use_by($type, $interval, $sweetSpot, $minimumAge, $shelfSort, $user['id']);

        $due_today_array = array();
        $overdue_array = array();
        $due_in_coming_week = array();

        $i = 0;
        while($artifact = mysqli_fetch_assoc($artifact_set)) { 

            date_default_timezone_set('America/New_York');
            $DateTimeNow = new DateTime(date('Y-m-d')); 
            $DateTimeMostRecentUse = new DateTime(substr($artifact['MostRecentUseOrResponse'],0,10)); 
            if ($artifact['MostRecentUseOrResponse'] === NULL) {
                $date_of_most_recent_use = 'No recorded uses';
            } else {
                $date_of_most_recent_use = $DateTimeMostRecentUse->format('Y-m-d');
            }
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

            $diff_days = $useByDate->diff($DateTimeNow)->days;

            if ($useByDate->format('Y-m-d') === $DateTimeNow->format('Y-m-d')) { // due today
                $due_today_array[$i]['artifact'] = h($artifact['Title']);
                $due_today_array[$i]['artifact_id'] = h($artifact['id']);
                $due_today_array[$i]['most_recent_use'] = $date_of_most_recent_use;
            } elseif ($diff_days > 0 && $diff_days < 8 && $useByDate->format('Y-m-d') > $DateTimeNow->format('Y-m-d')) { // due in coming week
                $due_in_coming_week[$i]['artifact'] = h($artifact['Title']);
                $due_in_coming_week[$i]['artifact_id'] = h($artifact['id']);
                $due_in_coming_week[$i]['use_by_date'] = $useByDate->format('Y-m-d');
                $due_in_coming_week[$i]['most_recent_use'] = $date_of_most_recent_use;
            } elseif ($useByDate->format('Y-m-d') < $DateTimeNow->format('Y-m-d')) { // due in past
                $overdue_array[$i]['artifact'] = h($artifact['Title']);
                $overdue_array[$i]['artifact_id'] = h($artifact['id']);
                $overdue_array[$i]['use_by_date'] = $useByDate->format('Y-m-d');
                $overdue_array[$i]['most_recent_use'] = $date_of_most_recent_use;
            } 
            $i++;
        }
    
        if(count($due_today_array) > 0 
            || count($overdue_array) > 0
            || count($due_in_coming_week) > 0
            ) { // email this list to the user

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
            $mail->setFrom(SENDGRID_FROM_EMAIL, APP_NAME);
            $mail->addAddress($email);
            $mail->addReplyTo(DEV_EMAIL, DEV_NAME);
   
            // Content
            $mail->isHTML(true);

            
            try {
                $mail->Subject = "Artifact Uses Due";
                $body = '';

                if (count($overdue_array) > 0) {
                    $body .= '
                        <h1>Artifacts overdue</h1>
                        <ul>
                    ';
    
                    foreach($overdue_array as $overdue) {
                        $name = $overdue['artifact'];
                        $most_recent_use = $overdue['most_recent_use'];
                        $use_by_date = $overdue['use_by_date'];
                        $id = $overdue['artifact_id'];
                        if ($most_recent_use === 'No recorded uses') {
                            $body .= "
                                <li>
                                    <a href='https://" . DOMAIN . "/artifacts/edit.php?id=$id'>$name</a>: 
                                    $most_recent_use, use by $use_by_date
                                </li>
                            ";
                        } else {
                            $body .= "
                                <li>
                                    <a href='https://" . DOMAIN . "/artifacts/edit.php?id=$id'>$name</a>: 
                                    last used $most_recent_use, use by $use_by_date
                                </li>
                            ";
                        }
                    }
    
                    $body .= '
                        </ul>
                    ';
                } 

                if (count($due_today_array) > 0) {
                    $body .= '
                        <h1>Artifact uses due today</h1>
                        <ul>
                    ';
    
                    foreach($due_today_array as $due_today) {
                        $name = $due_today['artifact'];
                        $most_recent_use = $due_today['most_recent_use'];
                        $id = $due_today['artifact_id'];
                        $body .= "
                            <li>
                                <a href='https://" . DOMAIN . "/artifacts/edit.php?id=$id'>$name</a>: 
                                last used $most_recent_use
                            </li>
                        ";
                    }
    
                    $body .= '
                        </ul>
                    ';
                } 

                if (count($due_in_coming_week) > 0) {
                    $body .= '
                        <h1>Artifacts due in coming week</h1>
                        <ul>
                    ';
    
                    foreach($due_in_coming_week as $artifact) {
                        $name = $artifact['artifact'];
                        $most_recent_use = $artifact['most_recent_use'];
                        $use_by_date = $artifact['use_by_date'];
                        $id = $artifact['artifact_id'];
                        if ($most_recent_use === 'No recorded uses') {
                            $body .= "
                                <li>
                                    <a href='https://" . DOMAIN . "/artifacts/edit.php?id=$id'>$name</a>: 
                                    $most_recent_use, use by $use_by_date
                                </li>
                            ";
                        } else {
                            $body .= "
                                <li>
                                    <a href='https://" . DOMAIN . "/artifacts/edit.php?id=$id'>$name</a>: 
                                    last used $most_recent_use, use by $use_by_date
                                </li>
                            ";
                        }
                    }
    
                    $body .= '
                        </ul>
                    ';
                } 

                $body .= '
                    <p>Record uses at <a href="https://' . DOMAIN . '/uses/1-n-new.php">' . DOMAIN . '</a></p>
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