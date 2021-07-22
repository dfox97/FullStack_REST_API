<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
//Connecting to the database 
class Database {
    private $host="studdb.csc.liv.ac.uk";
    private $user="sgdfox";
    private $passwd="NULL";
    private $database="sgdfox";
    public $conn;

    

//connecting to database
    public function connect() {
        $this->conn = null;
        
        $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false);
       
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' .$this->database . ';charset=utf8mb4',$this->user,$this->passwd,$opt);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(),503);
        }



//close connection

    return $this->conn;
    }
} 

?>
