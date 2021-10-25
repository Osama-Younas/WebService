<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Database.php';
include 'Validation.php';


$db_connection = new Database();
$conn = $db_connection->build_Connection();
$data = json_decode(file_get_contents("php://input"));


if($_SERVER["REQUEST_METHOD"] != "POST")//Check if request method is not $_POST send error message and terminate program
{
      $message_display=array("Status_code"=>404,"Message"=>'Page not found');//status code 404 because request method is wrong
      print_r(json_encode($message_display));
      http_response_code(404); 
      exit();
}
elseif(!($data->Name) || !isset($data->Gender) || !isset($data->Email) || !isset($data->Merchant_Password)||empty(trim($data->Name))|| empty(trim($data->Gender))|| empty(trim($data->Email))|| empty(trim($data->Merchant_Password)))
{
    $fields = ['fields' => ['Name','Gender','Email','Merchant_password']];
    $message_display=array("Status_code"=>422,"Message"=>'Fill all the feilds');
    print_r(json_encode($message_display));
    http_response_code(422); 
    exit();
}
else
{  
    $Name = trim($data->Name);
    $Gender=trim($data->Gender);
    $Email = trim($data->Email);
    $Merchant_Password= trim($data->Merchant_Password);

    if(!filter_var($Email, FILTER_VALIDATE_EMAIL))
    {
        $message_display=array("Status_code"=>422,"Message"=>'Invalid Email pattern');//status code 422 because user enter invalid email
        print_r(json_encode($message_display));
        http_response_code(422);  
    }
    elseif(strlen($Merchant_Password) < 8)
    {
        $message_display=array("Status_code"=>422,"Message"=>'Your password must be at least 8 characters and Atleast One Upper case letter!');//status code 422 because user enter less than 8 characters
        print_r(json_encode($message_display));
        http_response_code(422); 
    }

    elseif(strlen($Name) < 3)
    {
        $message_display=array("Status_code"=>422,"Message"=>'Enter Correct Name');//status code 422 
        print_r(json_encode($message_display));
        http_response_code(422); 
    }
    else
    {     
        $query= "INSERT INTO `merchant`(`Name`,`Gender`,`Email`,`Merchant_Password`) VALUES('{$Name}','{$Gender}','{$Email}','{$Merchant_Password}')";
        $result = $conn->query($query);
        $message_display=array("Status_code"=>200,"Message"=>'You have successfully registered.');
        print_r(json_encode($message_display));
        http_response_code(200); 

    }
}
?>
