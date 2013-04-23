<?php

// You MUST modify app_tokens.php to use your own Oauth tokens
require 'app_tokens.php';

// Create an OAuth connection
require 'tmhOAuth.php';
$connection = new tmhOAuth(array(
  'consumer_key'    => $consumer_key,
  'consumer_secret' => $consumer_secret,
  'user_token'      => $user_token,
  'user_secret'     => $user_secret
));


// Get the timeline with the Twitter API
$http_code = $connection->request('GET',$connection->url('application/rate_limit_status'), array(
    'resources' => 'search,statuses'
    ));

// Request was successful
if ($http_code == 200) {
  header('Content-Type: application/json; charset=utf-8');
  // Extract the tweets from the API response
  print $connection->response['response'];
// Handle errors from API request
} else {
  if ($http_code == 429) {
    print 'Error: Twitter API rate limit reached';
  } else {
    print 'Error: Twitter was not able to process that request';
  }
}
?>