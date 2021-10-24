<?php

include "Database.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Logout_user extends Database
{
 function logout($email)
 {
    $data = json_decode(file_get_contents("php://input"),true);
    $email = $data['email'];
    $status="INACTIVE";
    $token="Null";
    $db_connection = new Database();
    $conn = $db_connection->build_connection(); 

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $message_display=array("Status_code"=>422,"Message"=>'Invalid Email pattern');//status code 422 because user enter invalid email
        print_r(json_encode($message_display));
        http_response_code(422);  
    }
    else
    {
        $q = "UPDATE merchant SET Token = '{$token}' , m_status ='{$status}' where Email ='{$email}'";//Updating value of token and status
        $result = mysqli_query($conn,$q) or die("SQL QUERY FAIL.");
        $message_display=array("Status_code"=>200,"Message"=>'Logout');//status code 422 because user enter invalid email
        print_r(json_encode($message_display));
        http_response_code(200);  

    }  
 }

}
$Email = null;
$Logout = new Logout_user();
$Logout->logout($Email);
?>


