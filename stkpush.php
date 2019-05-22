<?php
header("Content-Type:application/json");

$shortcode='174379';
$lnm ='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$timestamp = date(YmdHis);

$consumerkey    ="ikkOuHNAGGHuVPjRWMpIRZG8r2XTA1Si";
$consumersecret ="79GQvVC0mGtUOp3d";

$targeturl="https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
$callbackurl="http://propertyfind.co.ke/ionoxis/confirmation.php?token=iKo_Kisi@giN1";

$authenticationurl='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';


$credentials= base64_encode($shortcode.$lnm.$timestamp);

$username=$consumerkey ;
$password=$consumersecret;

// Request headers
  $headers = array(  
    'Content-Type: application/json; charset=utf-8'
  );
  
  // Request
  $ch = curl_init($authenticationurl);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output
  curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password); // HTTP Basic Authentication
  $result = curl_exec($ch);  
  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
$result = json_decode($result);
$access_token=$result->access_token;
curl_close($ch);

//send request
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $targeturl);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); 
$curl_post_data = array(
  //The request parameters with valid values
    'BusinessShortCode' => $shortcode,
    'Password' => $credentials,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => '01',
    'PartyA' => '254714895246',
    'PartyB' => $shortcode,
    'PhoneNumber' => '254714895246',
    'CallBackURL' => $targeturl,
    'AccountReference' => "peteraccount",
    'TransactionDesc' => "petertest"   
);
$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
echo $curl_response;
?>