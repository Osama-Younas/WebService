<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database{

    public function build_connection(){     //build sql database connection 
        $conn = new mysqli("localhost","root","","mail_send_service");
        if ($conn->connect_error){
            echo "Database Connection Error";
        }
        else{
            echo "Database Connected";
            return $conn;
            
        }
        
    }
    public function close_connection($conn){   //close database connection
        $conn->close();
    }

   
}
?>