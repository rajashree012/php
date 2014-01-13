<?php
/* Class: Session
* Desc: Opens and maintains a PHP session.
*/
class Session
{
    private $message;
    function __construct()
    {
        session_start();
    } 
    function getVariable($varname)
    {
        if(isset($_SESSION['$varname'])) 
            return $_SESSION['$varname'];
        else
        {
            $this->message = "No such variable in this session";
        return FALSE;
        }
    }
    function storeVariable($varname,$value)
    {
        if(!is_string($varname)) 
        {
            throw new Exception("Parameter 1 is not avalid variable name.");
            return FALSE;
        }
        else 
        $_SESSION['$varname'] = $value;
    }
    function getMessage()
    {
        return $this->message;
    }
    function login(Account $acct,$password) 
    {
        if(!$acct->comparePassword($password)) 
        {
            return FALSE;
        }
        $this->storeVariable("auth","yes");
        return TRUE;
    }
}
?>