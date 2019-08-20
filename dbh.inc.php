<?php 

class Dbh
{
    protected static $myServer = "db";
    protected static $myUser = "devuser";
    protected static $myPassword = "devpass";
    protected static $myDB = "test_db";
    protected static $myPort = 3306;

    private static $_instance = NULL;
    
    public static function connexion ()
    {
        if (is_null (self::$_instance))
        {
            self::$_instance = new mysqli(self::$myServer, self::$myUser, self::$myPassword, self::$myDB, self::$myPort);
                /* check connection */
            if (self::$_instance->connect_errno) 
            {
                printf("Connection failed: %s\n", self::$_instance->connect_error);
                exit();
            }
			self::$_instance->autocommit(FALSE);
        }
        return self::$_instance;
    }

    public static function deconnexion ()
    {        
        if (!is_null (self::$_instance))
        {
            self::$_instance->close ();
            self::$_instance = NULL;
        }
    }
}
?>
