<?php
	session_start();

	require 'inc/config.php';

	require_once( 'autoload.php' );

	use Facebook\Facebook;
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

	echo '<pre>';
	print_r($session);
	echo '</pre>';

	if($session) {
		echo 'yo';
		$config = array(
    'appId' => '1431725387122854',
    'secret' => 'e60212162c4f437fada9fc8d82803172',
  );
		$facebook = new Facebook($config);
	  try {

	    $response = $facebook->api(
		  'me/blindseries:finish',
		  'POST',
		  array(
		    'blindtest' => "http://samples.ogp.me/1432620790366647"
		  )
		);

	  } catch(FacebookRequestException $e) {

	    echo "Exception occured, code: " . $e->getCode();
	    echo " with message: " . $e->getMessage();

	  }   

	}