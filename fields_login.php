<?php
/* File: fields_login.inc
* Desc: Contains arrays with the field names and form
* elements for the login Web page. The arrays named
* with l are displayed in form 1 and those named 
* with 2 are displayed in form 2. The forms are 
* defined in the file double_form.inc. 
*/
$page = array( "title” => “Customer Login Page",
               "top" => " ",
               "bottom" => "Send questions and comments to admin@ourplace.com",
);
$elements_1 = array( "top" => "Returning Customers: 
                               <span style=\"font-size: 80%; 
                               font-weight: 100%\">
                               <i>Login here</i></span>",
                     "bottom" => "",
                     "submit" => "Login"
);
$elements_2 = array("top" => "New Customers: 
                              <span style=\"font-size: 80%; 
                              font-weight: 100%\">
                              <i>Register here</i></span>",
                    "bottom" => "",
                    "submit" => "Register"
);
$fields_1 = array("fusername" => "User Name",
                  "fpassword" => "Password"
);
$length_1 = array("fusername" => "10",
                  "fpassword" => "10"
);
$fields_2 = array("user_name" => "User Name",
                  "password" => "Password",
                  "email" => "Email Address",
                  "first_name" => "First Name",
                  "last_name" => "Last Name",
                  "street" => "Street",
                  "city" => "City",
                  "state" => "State",
                  "zip" => "Zip",
                  "phone" => "Phone",
                  "fax" => "Fax"
);
$length_2 = array("user_name" => "20",
                  "password" => "8",
                  "email" => "55",
                  "first_name" => "40",
                  "last_name" => "40",
                  "street" => "55",
                  "city" => "40",
                  "zip" => "10",
                  "phone" => "15",
                  "fax" => "15"
); 
?>