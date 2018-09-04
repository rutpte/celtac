<?php
/**
 * DBConnection.class.php
 * Last Modify: May 2012
 * By Narong Rammanee
 */
// Include database configuration
class DBConnection
{
    /**
     * Stores a database object
     * 
     * @var object A database object
     */
    public $db;
    
    /**
     * __construct — Initialization connect to database. 
     * 
     * @param object $dbo a database object
     * @return No value is returned.
     */
    public function __construct($pdo=null)
    {
        // Checks for a DB object or creates one if one isn't found
        if (is_object($pdo)) {
            $this->db = $pdo;
        }else {
            // if class not pass parameter ,so connect 
            // Constants are defined in /sys/config/db-cred.inc.php
            try {
                // connect to postgres object databse
				//--> default is ... db.
                $this->db = new PDO(DSN_LMP, DB_USER, DB_PASS);//DSN_LMP,DSN_CLD
                $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // if can't connect display error message
                echo 'Connection failed: <pre>' . $e->getMessage();
            }
        }//end if
    }
    
    /**
     * __destruct — Database close connection
     * 
     * @return No value is returned.
     */
    public function __destruct() 
    {
        // database disconnect
        if (!empty($this->db)) $this->db = null;
    }
}
