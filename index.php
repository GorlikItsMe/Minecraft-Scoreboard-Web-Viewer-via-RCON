<?php
require_once('rcon/rcon.php');
require_once('core.php');
require_once('config.php');

$rcon = new Rcon($host, $port, $password, $timeout);
?>
  <body>
  <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
.type-dummy{background-color: #aea4ff;}
.type-stat{background-color: lime;}
.type-trigger{background-color: yellow;}

</style>
  Scoreboard
<?php
  if ($rcon->connect()){
    echo 'Connected<br>';
    $scoreboard = scoreboard($rcon);

    echo '<table>';
    echo '<tr>';
    echo '<th>Objective</th>';
    foreach ($scoreboard["PlayerList"] as $playername) {
      echo '<th>'.$playername.'</th>';
    }
    echo '</tr>';


    foreach ($scoreboard["VariablesList"] as $variablename => $value) {
      $vartypecolor = $value['type'];
      if (strpos($value['type'], 'stat') !== false) {$vartypecolor = 'stat';}

      echo '<tr class="type-'.$vartypecolor.'">';
      echo '<td>'.$variablename.'</td>';

      foreach ($scoreboard["PlayerList"] as $playername) {
        if (isset($scoreboard["Player"][$playername][$variablename])){$x = $scoreboard["Player"][$playername][$variablename];}
        else {$x = 'Not Defined';}
        echo '<td>'.$x.'</td>';
      }


      echo '</tr>';
    }

    echo '</table>';

  }else{
    echo 'Error, try Reload site or check config';
  }
?>  

</body></html>
