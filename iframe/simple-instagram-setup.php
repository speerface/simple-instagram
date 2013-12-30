<?php 

include('../../../../wp-blog-header.php'); 

$options_check = get_option('si_options');

$config = array(
            'apiKey'      => $options_check['instagram_app_id'],
            'apiSecret'   => $options_check['instagram_app_secret'],
            'apiCallback' => plugins_url( NULL , __FILE__ ) . '/simple-instagram-setup.php' // must point to success.php
          );

if(isset($_GET['code'])){
  $options_check = get_option('si_options');
  $instagram = new Instagram($config);
  $token = $instagram->getOAuthToken($_GET['code']);
  if(isset($token->access_token)){
  	update_option( 'si_oauth', $token->access_token );
  }else{
  	update_option( 'si_oauth', 'error');
  }
}


if(strlen($options_check['instagram_app_id']) > 0 && strlen($options_check['instagram_app_secret']) > 0){
  $set = 1;
}else{
  $set = 0;
}

$auth_check = get_option('si_oauth');
if(strlen($auth_check) > 0){
  $auth = 1;
}else{
  $auth = 0;
}?>

<head>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='../admin/assets/css/iframe.css' rel='stylesheet' type='text/css'>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>

<?php if($auth == 0){
  $instagram = new Instagram($config);
  // Display the login button
  $loginUrl = $instagram->getLoginUrl();
?> 

<div class="instagram">
	<span><i class="fa fa-instagram"></i></span><a href="<?php echo $loginUrl; ?>">Login with Instagram</a>
</div>
<?php }else{
	if($auth_check == 'error'){
		//Error with auth
		$instagram = new Instagram($config);
		// Display the login button
		$loginUrl = $instagram->getLoginUrl();
		?>
		<p>Whoops! It looks like there's a problem with your App credentials. Please check your entries in Step 02 and then use the button below to authorize the app once again.</p>
		<div class="instagram">
			<span><i class="fa fa-instagram"></i></span><a href="<?php echo $loginUrl; ?>">Login with Instagram</a>
		</div>
	<?php }else{
	  //We have auth credentials, check to make sure they haven't expired
	  $instagram = new Instagram($config);
	  $instagram->setAccessToken($auth_check);
	  $user = $instagram->getUser();
	  if(isset($user->data->username)){?>
	    <p>Alright! You're all set up and ready to go!</p>
	  <?php }else{
	  	//Auth token has expired. Show login button instead. 
	    $instagram = new Instagram($config);
	  	// Display the login button
	  	$loginUrl = $instagram->getLoginUrl();
	  ?>
	  <p>Whoops! It looks like your authorization has expired. Please use the button below to authorize the app once again.</p>
	  <div class="instagram">
			<span><i class="fa fa-instagram"></i></span><a href="<?php echo $loginUrl; ?>">Login with Instagram</a>
		</div>
	  <?php } ?>
	<?php }
} ?>
