<?php
require_once 'Database.php';
header('Content-Type: application/json; charset=utf-8');

//Maybe split the class up into Teams and Players? two seperate files maybe?? 
class Team{
        //Db
        private $conn;
        private $table_teams='Teams';
        private $tablep='Players';

        //Team properties
        public $tid,$Tname,$sport,$averageAge;
        public $pid,$surname,$firstname,$birth_date;

        public function __construct($db){
            $this->conn=$db;
        }

      
//links to my read.php file
        //get all teams ordered by name
        public function readAll(){
            //create query 
            $query = 'SELECT * FROM '.$this->table_teams.'  order by Tname';
            //prepared statement
            $stmt=$this->conn->prepare($query);
            //execute final statment 
            $stmt->execute();
            
            return $stmt;

        }

//These link to read_single_players file
        //Trying 4B) Info on ALL player of 1 team replace Players with '.$this->tablep.'
        
        public function read_single_teams($team_id){
            $query = 'SELECT * FROM Players AS P WHERE P.tid=?';
    
            $stmt=$this->conn->prepare($query);

            $stmt->execute(array($team_id));

            $data=array();
            while($row = $stmt->fetch())
            {
                $data[] = $row;
            }
            return $data;

        }


        // 4C)
        public function read_single_player($team_id,$player_id){
            //create query
            $query = 'SELECT * FROM '.$this->tablep.' where tid=? and pid=?';
    
            $stmt=$this->conn->prepare($query);

            $stmt->execute(array($team_id,$player_id));

            $data=array();
            while($row = $stmt->fetch())
            {
                $data[] = $row;
            }
            return $data;         

        }
       // 4D)
       public function addPlayer($team_id){
        //$query = 'INSERT INTO Teams (tid,Tname,sport,averageAge) VALUES (?,?,?,?)';
        $query = 'INSERT INTO ' . $this->tablep . ' SET pid = :pid, surname = :surname, firstname = :firstname, nationality= :nationality, birth_date = :birth_date, tid= :tid';
        //Prepare insert
        $stmt=$this->conn->prepare($query);

        // Clean data stops code running 
        //idea found with help from Traversy Media https://www.youtube.com/watch?v=-nq4UbD0NT8
        $this->pid = htmlspecialchars(strip_tags($this->pid));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->nationality = htmlspecialchars(strip_tags($this->nationality));
        $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
       
        

        // Bind data
        $stmt->bindParam(':pid', $this->pid);
        $stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':birth_date', $this->birth_date);
        $stmt->bindParam(':tid', $team_id);
        
        //making sure pid is not equal nothing
        if (empty($this->pid) && $this->pid==""){
            http_response_code(500);
            throw new Exception("Player ID not set",500);
        }
       
        // Execute query
        if($stmt->execute()) {
             return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    } 
        public function removePlayer($team_id,$player_id){
            //Remove Player ID instead of player name or tid due to possible duplicates
            $query = 'DELETE FROM ' . $this->tablep . ' WHERE tid=:tid AND pid = :pid';
            //prepare
            $stmt=$this->conn->prepare($query);
            
            //bind data
            $stmt->bindParam(':pid', $player_id);
            $stmt->bindParam(':tid', $team_id);
            //execute 
            
             // Execute query
            if($stmt->execute()){
                return true;
            }
            
            return false;
            

            
    

        }
        public function updatePlayer(){
            //Remove Player ID instead of player name or tid due to possible duplicates
            $query = 'UPDATE ' . $this->tablep . '
            SET surname = :surname, firstname = :firstname, nationality= :nationality, birth_date = :birth_date,tid= :tid
             WHERE pid = :pid';
            //prepare
            $stmt=$this->conn->prepare($query);
            
            // Clean data stops code running 
            //idea found with help from Traversy Media https://www.youtube.com/watch?v=-nq4UbD0NT8
            $this->pid = htmlspecialchars(strip_tags($this->pid));
            $this->surname = htmlspecialchars(strip_tags($this->surname));
            $this->firstname = htmlspecialchars(strip_tags($this->firstname)); 
            $this->nationality = htmlspecialchars(strip_tags($this->nationality));
            $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
            $this->tid = htmlspecialchars(strip_tags($this->tid));
            
            //bind data
            $stmt->bindParam(':pid', $this->pid);
            $stmt->bindParam(':surname', $this->surname);
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':nationality', $this->nationality);
            $stmt->bindParam(':birth_date', $this->birth_date);
            $stmt->bindParam(':tid', $this->tid);
            //execute 
            
             // Execute query 
             //using try and catch to stop incorrect sql data
             try{
                 if($stmt->execute()){
                 return true;
                }
             }
             catch (PDOException $e){
                echo 'Caught exception: ',  $e->getMessage(), "\n";
             }
             
            return false;
            
        }    
           
    }



   
?>