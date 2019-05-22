<?php
header("Content-Type:application/json");

if (!isset($_GET["token"]))
{
echo "Technical error";
exit();
}

if ($_GET["token"]!='iKo_Kisi@giN1')
{
echo "Invalid authorization";
exit();
}

if (!$request=file_get_contents('php://input'))
{
echo "Invalid input";
exit();
}



$server = "localhost";
$username = "xllhzwhu_ecom_admin";
$password = "CaPUg}FAA4!I";
$db = "xllhzwhu_ecom_test";
$con = mysqli_connect($server, $username, $password, $db);
$timestamp = date(YmdHis);

if (!$con) 
{
die("Connection failed: " . mysqli_connect_error());
}

$request=file_get_contents('php://input');
$res = json_decode($request, true);

//Put the json string that we received from Safaricom to an array
$array = json_decode($request, true);
$transactiontype= mysqli_real_escape_string($con,$array['TransactionType']); 
$transid=mysqli_real_escape_string($con,$array['TransID']); 
$transtime= mysqli_real_escape_string($con,$array['TransTime']); 
$transamount='';
//$transamount= mysqli_real_escape_string($con,$array['CallbackMetadata']['Item']['Amount']); 
$businessshortcode=  mysqli_real_escape_string($con,$array['BusinessShortCode']); 
$billrefno=  mysqli_real_escape_string($con,$array['BillRefNumber']); 
$invoiceno='';
//$invoiceno=  mysqli_real_escape_string($con,$array['CallbackMetadata']['Item']['MpesaReceiptNumber']); 
$msisdn='';
//$msisdn=  mysqli_real_escape_string($con,$array['CallbackMetadata']['Item']['PhoneNumber']); 
$orgaccountbalance=   mysqli_real_escape_string($con,$array['OrgAccountBalance']); 
$firstname=mysqli_real_escape_string($con,$array['FirstName']); 
$middlename=mysqli_real_escape_string($con,$array['MiddleName']); 
$lastname=mysqli_real_escape_string($con,$array['LastName']);

$sql="INSERT INTO mpesa_payments
( 
TransactionType,
TransID,
TransTime,
TransAmount,
BusinessShortCode,
BillRefNumber,
InvoiceNumber,
MSISDN,
FirstName,
MiddleName,
LastName,
OrgAccountBalance,
text,
tstamp
)  
VALUES  
( 
'$transactiontype', 
'$transid', 
'$timestamp', 
'$transamount', 
'$businessshortcode', 
'$billrefno', 
'$invoiceno', 
'$msisdn',
'$firstname', 
'$middlename', 
'$lastname', 
'$orgaccountbalance',
'$res',
'$timestamp'
)";

if (!mysqli_query($con,$sql))  
{ 
echo mysqli_error($con); 
} 

else 
{ 
echo '{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}';
}
 
mysqli_close($con);
?>