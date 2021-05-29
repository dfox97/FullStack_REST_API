<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
require_once 'Database.php';
require_once 'Teams.php';

$result = array();
//call database
$db = new Database();
$db=$db->connect();
// call object
$team=new Team($db);

//GET IDs from url 

//*************************************************************** */
//*                             4B/4C                           * */
//*************************************************************** */

if ($_SERVER['REQUEST_METHOD']=="GET"){
if(isset($_GET['tid']) && $_GET['tid'] != ''){
    if(isset($_GET['pid']) && $_GET['pid'] != ''){
        //if both tid and pid are set and not equal blank then execute 4C
        $players=$team->read_single_player($_GET['tid'],$_GET['pid']);
        if($players){
            $result = array(
            'status'=>'success',
            'message'=>'Players Fetched',
            'data'=>$players
        );
        }
    else{
        $result = array(
            'status'=>'error',
            'message'=>'No Players Found with Team id:'.$_GET["tid"]." and Player id:".$_GET["pid"],
            'data'=>null
        );

        }
    }
    else{
        //If url has tid then execute 
        $players = $team->read_single_teams($_GET['tid']);
        if($players){
            $result = array(
                'status'=>'success',
                'message'=>'Players Fetched',
                'data'=>$players
            );
        }
        else{
            $result = array(
                'status'=>'error',
                'message'=>'No Players Found',
                'data'=>null
            );
        }
    }
}
else{
    //anything else is a fail
    http_response_code(404);
    $result = array(
        'status'=>'error',
        'message'=>'No Teams Found',
        'data'=>null
    );
}
//print response
print json_encode($result);
}

//*************************************************************** */
//*                             4D                             * */
//*************************************************************** */

//ADDING PLAYER TO DATABASE IF METHOD IS POST
else if ($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_GET['tid']) && $_GET['tid'] != ''){
    //Get raw posted data
$data = json_decode(file_get_contents("php://input"));

    $team->pid = $data->pid;
    $team->surname = $data->surname;
    $team->firstname = $data->firstname;
    $team->nationality=$data->nationality;
    $team->birth_date = $data->birth_date;

    $players = $team->addPlayer($_GET['tid']);
    if($players){
            $result = array(
                'status'=>'success',
                'message'=>'Player Added to Team',
            );
        }
   else{
    http_response_code(404);
    $result = array(
        'status'=>'error',
        'message'=>'No Player added',
        'data'=>null
    );
}
   print json_encode($result);
}}

//*************************************************************** */
//*                             4E                              * */
//*************************************************************** */

else if ($_SERVER['REQUEST_METHOD']=="DELETE"){
    if(isset($_GET['tid']) && $_GET['tid'] != '' && isset($_GET['pid']) && $_GET['pid'] != ''){

        //Get raw posted data
        $data = json_decode(file_get_contents("php://input"));
        //sets pid to delete

        //$team->pid = $data->pid;
        $teamid=$_GET['tid'];
        $playerid=$_GET['pid'];
        
        $test=$team->read_single_player($teamid,$playerid);
        
       // print_r($teamid); TESTING
        //print_r("This is pid".$test[0]['pid']);
        //print_r("this is tid".$test[0]['tid']);

        //comparing the url if its a match remove player if not tell user that error has occured
        if($test[0]['tid']==$teamid && $test[0]['pid']==$playerid){
            $players=$team->removePlayer($teamid,$playerid);
            if($players){
            http_response_code(200);
            $result=array('status'=>'success',
                'message'=>'Player Removed from Team');
            }
            else{
                http_response_code(404);
            $result=array('status'=>'Error',
                'message'=>'Player not removed',
                'Data'=>Null);
            }
        }
        else{
            http_response_code(404);
        $result=array('status'=>'Error',
            'message'=>'Player not removed',
            'Data'=>Null);
        }
    }
    print json_encode($result);
}

//*************************************************************** */
//*                             4F                              * */
//*************************************************************** */

//Updating a player in a team
else if ($_SERVER['REQUEST_METHOD']=="PUT"){

    //Get raw posted data
    $data = json_decode(file_get_contents("php://input",TRUE));
    
    //dont have time to fix this, array object didnt work when i tried the methods for read.
    //bind each param
    $team->pid = $data->pid;
    $team->surname = $data->surname;
    $team->firstname = $data->firstname;
    $team->nationality=$data->nationality;
    $team->birth_date = $data->birth_date;
    $team->tid = $data->tid;
   
    $players=$team->updatePlayer();
    //Reading player function to compare and confirm id exists
    $test=$team->read_single_player($team->tid,$team->pid);
    
//couldnt get array working so i could use fetch or rowCount ect.. so done it a long way so user who inputs incorrect pid or tid gets a no ID exists.

    if ($test[0]['pid']== $team->pid){
        if ($players) {
        echo json_encode(['message' => 'Player Updated']);
        }
    }
    else if ($test[0]['pid']!== $team->pid){
        http_response_code(404);
        echo json_encode(['message' => 'Player ID pid doesnt exist']);
    }   
    else{
        http_response_code(404);
        echo json_encode(['message' => 'Player Not Updated']);
    }
    
}



//ANYTHING ELSE THROW AN EXCEPTION
else{
    http_response_code(500);
    throw new Exception('Method Not Supported',500);
}
?>