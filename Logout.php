<?php

include "Database.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Logout_marchent extends Database
{
 function logout($key)
 {
    $data = json_decode(file_get_contents("php://input"),true);
    $db_connection = new Database();
    $conn = $db_connection->build_connection(); 
    $key = $data['token'];
    if(isset($key))
    {
        $query ="Select * from merchant where Token ='{$key}'";
        $result = $conn->query($query);
      
        if(mysqli_num_rows($result)>0)
        {
            $get_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $id = $get_data['Id'];
            $status="INACTIVE";
            $token="Null";


            $q = "UPDATE merchant SET Token = '{$token}' , m_status ='{$status}' where  id='{$id}'";//Updating value of token and status
            $result = mysqli_query($conn,$q) or die("SQL QUERY FAIL.");
            $message_display=array("Status_code"=>200,"Message"=>'Logout');//status code 422 because user enter invalid email
            print_r(json_encode($message_display));
            http_response_code(200);  
        }
    }  
 }

}

$Logout = new Logout_marchent();
$Logout->logout($key);
?>


