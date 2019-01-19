<?php


function getPlayersList($rcon){
    $playerslist = ($rcon->send_command('scoreboard players list'));
    $playerslist = explode(", ",split(':', $playerslist)[1]);
    $_a = explode(" and ",$playerslist[count($playerslist)-1]);
    array_pop($playerslist);
    array_push($playerslist, $_a[0], $_a[1]);
    return $playerslist;
}

//scoreboard objectives list
function getVariablesList($rcon){
    $var = ($rcon->send_command('scoreboard objectives list'));
    $var = explode("- ", $var); 
    array_shift($var);
    $r = array();
    foreach ($var as $x){
        $_name = explode(": ", $x)[0];
        $_display = explode("' ", explode("displays as '", $x)[1])[0];
        $_type = explode("'", explode("type '", $x)[1])[0];
        //$_obj = ["name" => $_name, "display" => $_display, "type" => $_type];
        //array_push($r, $_obj);
        $r[$_name] = ["display" => $_display, "type" => $_type];
    }
    return $r;
}

//tellraw @p ["",{"score":{"name":"@p","objective":"startGame"}}]
function getPlayerVariable($rcon, $player){
    $var = ($rcon->send_command('scoreboard players list '.$player));
    $var = explode("- ", $var); 
    array_shift($var);
    $r = array();
    foreach ($var as $x){
        $_name = explode(": ", $x)[0];
        $_value = explode(" (", explode(": ", $x)[1])[0];
        //$_obj = [$_name => $_value];
        //array_push($r, $_obj);
        $r[$_name] = $_value;
    }
    return $r;
}

function scoreboard($rcon){
    $players = getPlayersList($rcon);
    $variables = getVariablesList($rcon);
    $playerstats = array();
    foreach ($players as $pl){
        $playerstats[$pl] = getPlayerVariable($rcon, $pl);
    }
    return ["PlayerList" => $players, "VariablesList"=>$variables, "Player" => $playerstats];
}

?>