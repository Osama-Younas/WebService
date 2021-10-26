<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Database.php';
include 'Validation.php';


$db_connection = new Database();
$conn = $db_connection->build_Connection();

$data = json_decode(file_get_contents("php://input"),true);

$key=$data["token"];
$card_number=$data["card_number"];
$cvc_number=$data["cvc_number"];
$valid_from=$data["valid_from"];
$valid_till=$data["valid_till"];



if(isset($key))//check if token is set 
{
  $query ="Select * from merchant where Token ='{$key}'";
  $result = $conn->query($query);

  if(mysqli_num_rows($result)>0)
  {
      $get_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $id = $get_data['Id'];

    if($_SERVER["REQUEST_METHOD"] != "POST")//Check if request method is not $_POST send error message and terminate program
    {
       $message_display=array("Status_code"=>404,"Message"=>'Page not found');//status code 404 because request method is wrong
       print_r(json_encode($message_display));
       http_response_code(404); 
       exit();
    }
    elseif(!($card_number)  || !isset($cvc_number) || !isset($valid_from)|| !isset($valid_till)
    ||empty(trim($card_number))|| empty(trim($cvc_number))|| empty(trim($valid_from))|| empty(trim($valid_till)))
     { 
       $message_display=array("Status_code"=>422,"Message"=>'Fill all the feilds');
       print_r(json_encode($message_display));
       http_response_code(422); 
       exit();
     }
     else
    {  
       $card_number = trim($card_number);
       $cvc_number= trim($cvc_number);
       $valid_from= trim($valid_from);
       $valid_till=trim($valid_till);

       if(strlen($card_number) > 16)
       {
          $message_display=array("Status_code"=>422,"Message"=>'Invalid credit card number');
          print_r(json_encode($message_display));
          http_response_code(422); 
       } 
         elseif(strlen($cvc_number) > 4)
       {
          $message_display=array("Status_code"=>422,"Message"=>'Invalid Cvc number');//status code 422 
          print_r(json_encode($message_display));
          http_response_code(422); 
       }
       else
       {   
           $credit=100;
           $query= "INSERT INTO `card`(`card_number`,`credit`,`cvc_number`,`valid_from`,`valid_till`) VALUES('{$card_number}','{$credit}','{$cvc_number}','{$valid_from}','{$valid_till}')";
           $result = mysqli_query($conn,$query) or die("SQL QUERY FAIL.");
           print_r($result);
           $q = "UPDATE `card` SET merchant_id = '{$id}'";
           $result = mysqli_query($conn,$q) or die("SQL QUERY FAIL.");
           $message_display=array("Status_code"=>200,"Message"=>'You have successfully entered the card details you got $100 credit');
           print_r(json_encode($message_display));
           http_response_code(200); 
       }
     }
   } 
}

?>