<?php
/* Class: Account
* Desc: A user account stored in a database. Represents
* the account information stored in one record 
* in a table.
*/
class Account
{
    private $userID = NULL; 
    private $cxn; // database connection object
    private $table_name; 
    private $message; 
    function __construct( mysqli $cxn,$table)
    {
        $this->cxn = $cxn;
        if(is_string($table)) 
        {
            $sql = "SHOW TABLES LIKE '$table'"; 
            $result = $this->cxn->query($sql);
            if($result->num_rows > 0) #21
            {
                $this->table_name = $table;
            }
            else 
            {
                throw new Exception("$table is not a table in the database");
                return FALSE;
            }
        }
        else 
        {
            throw new Exception("Second parameter is not a valid table name");
            return FALSE;
        }
    }
    function selectAccount($userID)
    {
        $userID = trim($userID); 
        $sql = "SELECT user_name FROM $this->table_name 
                WHERE user_name ='$userID'"; 
        if(!$result = $this->cxn->query($sql))
        {
            throw new Exception("Couldn't execute query: ".$this->cxn->error());
            return FALSE;
        }
        if($result->num_rows < 1 ) 
        {
            $this->message = "Account $userID does not exist!"; 
            return FALSE;
        }
        else #57
        {
            $this->userID = $userID;
            return TRUE;
        }
    }
    function comparePassword($form_password)
    {
        if(!isset($this->userID)) 
        {
            throw new Exception("No account currently selected");
            exit();
        } #70
        $sql = "SELECT user_name FROM $this->table_name
                WHERE user_name ='$this->userID' AND
                password = md5('$form_password')";
        if(!$result = $this->cxn->query($sql)) 
        {
            throw new Exception("Couldn't execute query: ".mysql_error());
            exit();
        }
        if($result->num_rows < 1 ) 
        {
            $this->message = "Incorrect password for 
            account $this->userID!";
            return FALSE;
        }
        else #86
            return TRUE;
    }
    function getMessage()
    {
        return $this->message;
    }
    function createNewAccount($data)
    {
        if(!is_array($data)) 
        {
            throw new Exception("Data must be in an array.");
            return FALSE;
        }
        foreach($data as $field => $value) 
        {
            if($field != "password" and $field != "Button") 
            {
                $fields[] = $field;
                $values[] = addslashes($value); 
            }
        }
        $str_fields = implode($fields,","); 
        $str_values = '"'.implode($values,'","'); 
        $today = date("Y-m-d"); 
        $str_fields .=",create_date";
        $str_fields .=",password";
        $str_values .="\",\"$today";
        $str_values .="\",md5(\"{$data['password']}\")"; 
        $sql = "INSERT INTO $this->table_name ($str_fields) 
        VALUES ($str_values)";
        if(!$this->cxn->query($sql)) #119
        { 
            throw new Exception("Can’t execute query: ".$this->cxn->error());
            return FALSE;
        }
        else 
        { 
            return TRUE;
        }
    }
} 
?>