<?php
/*
	Parse signedRequest function
*/


$pr_signed_request = trim($_POST['pr_signed_request']);
$pr_secret = '74882433b219c4114d4d7dafd34679dd';



  list($encoded_sig, $payload) = explode('.', $pr_signed_request, 2); 


  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);



  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
   // error_log('Unknown algorithm. Expected HMAC-SHA256');
   //echo 1;
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $pr_secret, $raw = true);
  if ($sig !== $expected_sig) {
   // error_log('Bad Signed JSON signature!');
  // echo 2;
    return null;
  }


//echo "@@Code value : ".$data['code'];	
//echo "@@algorithm value : ".$data	['algorithm'];
//echo "@@user_id value : ".$data['user_id'];
//echo "@@user value : ".$data['user'];	
//echo "@@oauth_token value : ".$data['oauth_token'];
//echo "@@expires value : ".$data['expires'];	
//echo "@@app_data value : ".$data['app_data'];
//echo "@@algorithm value : ".$data['algorithm'];	
//echo "@@page value : ".$data['page'];

//echo $data;

$output = json_encode($data);
print($output);


function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}



?>