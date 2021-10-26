<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include 'Database.php';
include 'validation.php';
require __DIR__.'/classes/JwtHandler.php';


$db_connection = new Database();
$conn = $db_connection->build_connection();


$data = json_decode(file_get_contents("php://input"));

if($_SERVER["REQUEST_METHOD"] != "POST")//Check if request method is not $_POST send error message and terminate program
{
      $message_display=array("Status_code"=>404,"Message"=>'Page not found');//status code 404 because request method is wrong
      print_r(json_encode($message_display));
      http_response_code(404); 
      exit();
}
elseif(!isset($data->email) || !isset($data->password)|| empty(trim($data->email))|| empty(trim($data->password)) )
{
    $message_display=array("Status_code"=>422,"Message"=>'Invalid Email pattern');//status code 422 because user enter invalid email
    print_r(json_encode($message_display));
    http_response_code(422);  
}

else
{
    $email = trim($data->email);
    $password = trim($data->password);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $message_display=array("Status_code"=>422,"Message"=>'Invalid Email pattern');//status code 422 because user enter invalid email
        print_r(json_encode($message_display));
        http_response_code(422);  
    }
    elseif(strlen($password) < 8)
    {
        $message_display=array("Status_code"=>422,"Message"=>'Your password must be at least 8 characters and Atleast One Upper case letter!');//status code 422 because user enter less than 8 characters
        print_r(json_encode($message_display));
        http_response_code(422); 
    }

    else
    {
      $query = "SELECT * FROM  admin WHERE a_password = '{$password}' AND  email='{$email}'";
      //sql query to check Password and email is present in databse 
        
      $result = mysqli_query($conn,$query) or die("SQL QUERY FAIL.");
           
      if(mysqli_num_rows($result)>0)
      {
          $get_data = mysqli_fetch_array($result, MYSQLI_ASSOC);

          $jwt = new JwtHandler();
          $token = $jwt->_jwt_encode_data('',array("id"=> $get_data['id'],"email"=>['Email']));

          $status="ACTIVE";
          $q = "UPDATE admin SET token = '{$token}' , a_status ='{$status}' where email = '{$email}'";//Updating value of token and status
          $result = mysqli_query($conn,$q) or die("SQL QUERY FAIL.");

          $message_display=array("Status_code"=>200,"Message"=>"Successfully Login","token" => $token);//if password and email are matched display this message
          http_response_code(200);
          print_r(json_encode($message_display));
      }
      else
      {
           $message_display=array("Status_code"=>422,"Message"=>"Invalid Email or password");//if password and email are wrong display error message
            http_response_code(422); 
            print_r(json_encode($message_display));
      }
    }
}
?>

