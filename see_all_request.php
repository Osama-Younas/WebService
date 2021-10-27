<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Database.php';


$db_connection = new Database();
$conn = $db_connection->build_Connection();

$data = json_decode(file_get_contents("php://input"),true);

$key=$data["token"];

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
    else
    {
        $query="select * from response";
        $result = $conn->query($query);
        if(mysqli_num_rows($result)>0)
        {
          while  ($get_info = mysqli_fetch_array($result, MYSQLI_ASSOC))

            {
               $id=$get_info['Id'];
               $status=$get_info['Status'];
               $error=$get_info['error'];    
               $message_display=array("ID"=>$id,"STATUS"=>$status,"ERROR"=>$error);
               print_r(json_encode($message_display));
               http_response_code(200);             
            }   
         }


    }

  }
}


?>