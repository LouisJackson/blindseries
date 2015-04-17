<?php

// Pass session data over.
session_start();

// Include the required dependencies.
require 'inc/config.php';
require_once( 'autoload.php' );

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;

// Initialize the Facebook SDK.
FacebookSession::setDefaultApplication( '1431725387122854', 'e60212162c4f437fada9fc8d82803172' );
$helper = new FacebookRedirectLoginHelper('http://louisamiot.com/lab/series/');

try {
    if ( isset( $_SESSION['access_token'] ) ) {
        // Check if an access token has already been set.
        $session = new FacebookSession( $_SESSION['access_token'] );

    } else {
        // Get access token from the code parameter in the URL.
        $session = $helper->getSessionFromRedirect();
    }
} catch( FacebookRequestException $ex ) {

    // When Facebook returns an error.
    print_r( $ex );
} catch( \Exception $ex ) {

    // When validation fails or other local issues.
    print_r( $ex );
}

if ( isset($session) ) {

    // Retrieve & store the access token in a session.
    $_SESSION['access_token'] = $session->getToken();
    // Logged in

            /* make the API call */
    $request = new FacebookRequest(
      $session,
      'GET',
      '/me'
    );
    $response = $request->execute();
    $graphObject = $response->getGraphObject()->asArray();
    /* handle the result */

    $theID = $graphObject['id'];
    $_SESSION['id'] = $theID;
    if (isset($theID)) {
        $prepare = $pdo->prepare('SELECT * FROM bs_users WHERE facebook_id = :facebook_id LIMIT 1');
        $prepare->bindValue(':facebook_id',$theID);
        $prepare->execute();
        $newID = $prepare->fetch();
        if (!$newID) {
            $prepare = $pdo->prepare('INSERT INTO bs_users (facebook_id) VALUES (:facebook_id)');
            $prepare->bindValue(':facebook_id',$theID);
            $prepare->execute();
        }
    }
    header('Location:category.php');
    exit;

} else {

    // Generate the login URL for Facebook authentication.
    $loginUrl = $helper->getLoginUrl();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blind Series | Homepage</title>
    <link rel="stylesheet" type="text/css" href="src/css/reset.css">
    <link rel="stylesheet" type="text/css" href="src/css/style.css">
     <link rel="stylesheet" type="text/css" href="src/css/font-awesome-4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>

</head>



<body class="full-screen-background">
    <header>
    
    <div id="logo">
        <img src="src/img/logo.png" title="logo" alt="logo"/>
        <h1>BLIND SERIES</h1>
    </div>
</header>




        <div class="welcome">
            <span>"Access to the Experience Blind Series and join the community of TV shows passionate."</span>
        

            <div class="social">
                <a href="<?php echo $loginUrl; ?>" class="rounded rounded--facebook">
                    <i class="fa fa-facebook fa-2x"></i>
                        <span class="connect-with-facebook">CONNECT WITH FACEBOOK</span>
                </a>
            </div>
        </div>
</body>
</html>