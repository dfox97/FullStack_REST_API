<?php
// simply calls the read function from Teams.php and produces a json out reading all Teams with a link to view team players.

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once 'Database.php';
require_once 'Teams.php';


//call database
$db = new Database();
$db=$db->connect();
//instantiate player object
$team=new Team($db);
//Retrieveinputs


$results=array();
//player query
$t=$team->readAll();
        //get row count
$num=$t->rowCount();

//check if any data
if($t){
        //post array
        $team_arr=array();
        

        $i=1;//counter
        //print array with links to all players 
        foreach($t as $teams){
            $team_arr[$i]=$teams;
            $team_arr[$i]['All Players: href=']= "/players/tid/".$teams['tid']."/";
            //$team_arr[$i]["Method"]="GET";
            //$team_arr[$i]["rel"]="All players on a team";
            $i++;

        }
        


        http_response_code(200);
        $result=array(
            'status'=>'success',
            'message'=>'All Teams Fetched',
            'data'=>$team_arr,
        );
    }
else{
    http_response_code(404);
    $result = array(
        'status'=>'error',
        'message'=>'No Teams Found',
        'data'=>null
    );
}
// fixing the problem i had with \/ by setting flag
    print json_encode($result,JSON_UNESCAPED_SLASHES);
    
?>