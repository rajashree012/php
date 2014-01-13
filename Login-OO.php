<?php
/* Program: Login-OO.php
* Desc: User Login Application script. The program
* displays the Login Web page. New customer 
* registration information is validated and
* stored in a database. Existing customers'
* passwords are compared to valid passwords.
*/
require_once("WebForm.php"); #9
require_once("Account.php");
require_once("Database.php");
require_once("Session.php");
require_once("Email.php");
try #15
{
    $form = new WebForm("double_form.php","fields_login.php",$_POST);
}
catch(Exception $e)
{
    echo $e->getMessage();
    exit();
}
//First time form is displayed. Form is blank. //
if (!isset($_POST['Button'])) #26
{
    $form->displayForm();
    exit();
}
// Process form that has been submitted with user info //
else 
{
    $sess = new Session(); #34
    try
    {
    $db = new Database("Vars.php"); #37
    $db->useDatabase("mydb"); #38
    $acct = new Account($db->getConnection(),"Customer");
    }
    catch(Exception $e)
    {
        echo $e->getMessage()."\n<br>";
        exit();
    }
    // Login form was submitted // 
    if (@$_POST['Button'] == "Login") #48
    {
        try
        {
            $blanks = $form->checkForBlanks(); #52
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
        if(is_array($blanks)) #59
        {
            $GLOBALS['message_1'] = "User name or Password was blank. Please enter both.";
            $form->displayForm();
            exit();
        } 
        try
        { 
            if(!$acct->selectAccount($_POST['fusername'])) #69
            {
                $GLOBALS['message_1'] = $acct->getMessage(). " Please try again.";
                $form->displayForm();
                exit();
            }
            if(!$sess->login($acct,$_POST['fpassword'])) #76
            {
                $GLOBALS['message_1'] = $acct->getMessage()." Please try again.";
                $form->displayForm();
                exit();
            }
            header("Location: SecretPage.php"); #83
            exit();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        } 
    }
    // Registration form was submitted //
    elseif($_POST['Button'] = "Register") #93
    {
        $not_required[] = "fax"; #95
        try
            {
            $form->setFieldsNotRequired($not_required); #98
            $blanks = $form->checkForBlanks(); #99
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        if(is_array($blanks)) #105
        {
            $GLOBALS['message_2'] = "The following required fields were blank. Please enter the required information: ";
            foreach($blanks as $value)
            {
                $GLOBALS['message_2'] .="$value, ";
            }
            $form->displayform();
            exit();
        }
        $form->trimData(); #117
        $form->stripTagsFromData(); #118
        try
        {
            $errors = $form->verifyData(); #121
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        if(is_array($errors)) #127
        {
            $GLOBALS['message_2'] = "";
            foreach($errors as $value)
            {
                $GLOBALS['message_2'] .="$value<br> ";
            }
            $form->displayform();
            exit();
        } 
        $newdata = $form->getAllFields();
        try
        {
            if($acct->selectAccount($newdata['user_name'])) #140
            {
                $GLOBALS['message_2'] = "Member ID already used. Select a new Member ID.";
                $form->displayForm();
                exit();
            }
            if(!$acct->createNewAccount($newdata)) #148
            {
                echo "Couldn't create new account. 
                Try again later.";
                exit();
            }
            $sess->storeVariable("auth","yes"); #154
            $sess->storeVariable("logname",$newdata['user_name']);
            $em = new Email(); #156
            $em->setAddr($newdata['email']);
            $em->setSubj("Your new customer registration");
            $emess = "Your new customer account has been setup.";
            $emess .= " Your new user name and password are: ";
            $emess .= "\n\n\t{$newdata['user_name']}\n\t";
            $emess .= "{$newdata['password']}\n\n";
            $emess .= "We appreciate your interest. \n\n";
            $emess .= "If you have any questions or problems,";
            $emess .= " email service@ourstore.com";
            $em->setMessage($emess);
            $em->sendEmail(); #167
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
        header("Location: SecretPage.php");
    }
}
?>
