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
$name=$data["name"];
$gender=$data["gender"];
$email=$data["email"];
$user_password=$data["user_password"];
$email_permission=$data["email_permission"];
$list_view_permission=$data["list_view_permission"];
$payment_permission=$data["payment_permission"];


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
    elseif(!($name) || !isset($gender) || !isset($email) || !isset($user_password)|| !isset($email_permission)|| !isset($list_view_permission)|| !isset($payment_permission)||empty(trim($name))|| empty(trim($gender))|| empty(trim($email))|| empty(trim($user_password))|| empty(trim($email_permission))|| empty(trim($list_view_permission))|| empty(trim($payment_permission)))
     { 
       $fields = ['fields' => ['name','gender','email','user_password','email_permission','list_veiw_permission','payment_permission']];
       $message_display=array("Status_code"=>422,"Message"=>'Fill all the feilds');
       print_r(json_encode($message_display));
       http_response_code(422); 
       exit();
     }
     else
    {  
       $name = trim($name);
       $gender=trim($gender);
       $email = trim($email);
       $user_password= trim($user_password);
       $email_permission=trim($email_permission);
       $list_view_permission = trim($list_view_permission);
       $payment_permission= trim($payment_permission);


       if(!filter_var($email, FILTER_VALIDATE_EMAIL))
       {
          $message_display=array("Status_code"=>422,"Message"=>'Invalid Email pattern');//status code 422 because user enter invalid email
          print_r(json_encode($message_display));
          http_response_code(422);  
       }
       elseif(strlen($user_password) < 8)
       {
          $message_display=array("Status_code"=>422,"Message"=>'Your password must be at least 8 characters and Atleast One Upper case letter!');//status code 422 because user enter less than 8 characters
          print_r(json_encode($message_display));
          http_response_code(422); 
       } 
         elseif(strlen($name) < 3)
       {
          $message_display=array("Status_code"=>422,"Message"=>'Enter Correct Name');//status code 422 
          print_r(json_encode($message_display));
          http_response_code(422); 
       }
       else
       {   
           $query= "INSERT INTO `secondary_user`(`name`,`gender`,`email`,`user_password`,`email_permission`,`list_view_permission`,`payment_permission`) VALUES('{$name}','{$gender}','{$email}','{$user_password}','{$email_permission}','{$list_view_permission}','{$payment_permission}')";
           $result = $conn->query($query);
           $q = "UPDATE secondary_user SET merchant_id = '{$id}'";
           $result = mysqli_query($conn,$q) or die("SQL QUERY FAIL.");
           $message_display=array("Status_code"=>200,"Message"=>'You have successfully registered the new user.');
           print_r(json_encode($message_display));
           http_response_code(200); 
       }
     }
   } 
}

?>