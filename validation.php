<?php
    class Validate     //Create validation class to check all the input in correct methord :
    {

        public function email_validate($email)      //email_validate function get one parmeter and check email pattern if pattern match return true else false
                                                    
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false; 
            }
            else{
                return true;
            } 
        }
        public function password_validate($password)        //password_validate function get one parmeter and check password pattern if pattern match return true else false
        {
            $password_pattern='/^(?=.*[A-Z]).{8,20}$/';     //password length > 8 and also 1 uppercase charecter
            if(!preg_match($password_pattern, $password)){  //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        public function phone_Validate($phone)      //password_validate function get one parmeter and check password pattern if pattern match return true else false
        {
            $phone_pattern = "/^(03)+([0-4]{1})+([0-9]{1})[-]([0-9]{7})$/";     //number of total length 11 start 03 and next to digit between 00-49 next 7 digit 0-9
            if(!preg_match($phone_pattern, $phone)){    //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        public function name_validate($name)        //password_validate function get one parmeter and check password pattern if pattern match return true else false
        {
            $name_pattern="/^[a-zA-Z ]*$/";     //Not Accept Special character and digit
            if(!preg_match($name_pattern, $name)){      //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        public function cnic_validate($cnic)        //password_validate function get one parmeter and check password pattern if pattern match return true else false
        {
            $cnic_pattern="/^([0-9]{5})[-]([0-9]{7})[-]([0-9]{1})$/"; //length of CNIC is 13 and first - after 5 digit second - after 7 digit 
            if(!preg_match($cnic_pattern, $cnic)){      //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
    }
?>



