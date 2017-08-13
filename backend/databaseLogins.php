<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/config.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/utilityFunctions.php';

    function discordOauthLogin() {

        // Create a multi-part form for the POST request
        $data = array(
            'client_id' => $GLOBALS['OAUTH_ID'], 
            "code" => $_GET['code'], 
            "client_secret" => $GLOBALS['OAUTH_TOKEN'], 
            "grant_type" => "authorization_code"
        );
        // return json_encode($data);

        // Get the access token
        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, "https://discordapp.com/api/oauth2/token"); 
        curl_setopt($curl, CURLOPT_POST, 1);  // Set to POST
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  // Return as string
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); 
        $output = curl_exec($curl);  
        curl_close($curl);

        // Decode that to JSON
        $jsonData = json_decode($output, true); 
        // return json_encode($jsonData);

        // Get the user ID
        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, "https://discordapp.com/api/users/@me"); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  // Return as string
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $jsonData['access_token']));
        $output = curl_exec($curl);  
        curl_close($curl);  

        // Decode THAT to JSON too
        $jsonData = json_decode($output, true);
        // return json_encode($jsonData);
        $discordUserID = $jsonData['id'];

        // And return~
        // $discordUserID = 'test post please ignore';
        return $discordUserID;

    }

    function checkLoggedIn() {
        try {

            $dbh = new PDO(
                $GLOBALS['DB_TYPE'] . ':host=' . $GLOBALS['DB_HOST'] . '; dbname=' . $GLOBALS['DB_NAME'] . ';', 
                $GLOBALS['DB_USER'], 
                $GLOBALS['DB_PASS']
            ); 

            // Check for a person with the same cookie
            if (isset($_COOKIE['loginToken'])) {
                $stmt = $dbh->prepare('SELECT * FROM LoginData WHERE cookie_val=:cookie LIMIT 1;');
                $stmt->bindParam(':cookie', $_COOKIE['loginToken'], PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {

                    // A person with that cookie exists - send back data
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $iterator = new IteratorIterator($stmt);
                    foreach ($iterator as $row) {
                        return $row;
                    }
                }
            }

            // Cookie isn't set
            return false;

        }
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
            return false;
        }

    }

    function setLogin() {

        $discordID = discordOauthLogin();

        try {

            $dbh = new PDO(
                $GLOBALS['DB_TYPE'] . ':host=' . $GLOBALS['DB_HOST'] . '; dbname=' . $GLOBALS['DB_NAME'] . ';', 
                $GLOBALS['DB_USER'], 
                $GLOBALS['DB_PASS']
            ); 

            // Check for a person with that Discord ID
            $stmt = $dbh->prepare('SELECT * FROM LoginData WHERE discord_id=:discordID LIMIT 1;');
            $stmt->bindParam(':discordID', $discordID, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return 'No account exists';
            }

            // A person exists - set their cookies and save to the database
            $cookieValue = generateRandomString(64);
            setcookie('loginToken', $cookieValue, time() + (86400 * 30), "/"); // 30 days
            $stmt = $dbh->prepare('UPDATE LoginData SET cookie_val=:cookie WHERE discord_id=:discordID;');
            $stmt->bindParam(':discordID', $discordID, PDO::PARAM_STR);
            $stmt->bindParam(':cookie', $cookieValue, PDO::PARAM_STR);
            $stmt->execute();

            // Yay they're logged in
            return true;

        }
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
            return $e->getMessage();
        }

    }

    function setLogout() {

        try {

            $dbh = new PDO(
                $GLOBALS['DB_TYPE'] . ':host=' . $GLOBALS['DB_HOST'] . '; dbname=' . $GLOBALS['DB_NAME'] . ';', 
                $GLOBALS['DB_USER'], 
                $GLOBALS['DB_PASS']
            ); 

            // Check for a person with that Discord ID
            $stmt = $dbh->prepare('SELECT * FROM LoginData WHERE cookie_val=:cookie LIMIT 1;');
            $stmt->bindParam(':cookie', $_COOKIE['loginToken'], PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return;
            }

            // A person exists - set their cookies and save to the database
            setcookie('loginToken', 'null', time() - (86400 * 30), "/"); // 30 days ago
            $stmt = $dbh->prepare('UPDATE LoginData SET cookie_val=NULL WHERE discord_id=:discordID;');
            $stmt->bindParam(':discordID', $discordID, PDO::PARAM_STR);
            $stmt->execute();

            // Yay they're logged in
            return true;

        }
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
            return;
        }

    }

?>
