<html>
<body>


<?php
include "marvelfunction.php";
include "Fight.php";

$t_id = $_GET["t_id"];
$fight_id = $_GET["fight_id"];

$hostname = "localhost";
$dbname = "MarvelHeroBattle";
$username = "postgres";
$pass = "159";
try{
    $dsn = "pgsql:host=$hostname;port=5432;dbname=$dbname";
    $db= new PDO($dsn,$username,$pass);
}catch(PDOException $pdoE){
    die($pdoE->getMessage());
    exit();
}

$fights = getFightsFromDB($db, $t_id);
$fight = $fights[$fight_id];

?>
<h1 align="center">Fight's Record</h1>
<p align="center">
    <?php

    $arr = fightNo_toRound($fight_id);

    $xChar = getCharDataFromName(getCharInDB_withID($db,$fight->xfighter_id)->hero_name);
    $yChar = getCharDataFromName(getCharInDB_withID($db,$fight->yfighter_id)->hero_name);

    print '<h2 align="center">Round-'.$arr[0].':'.$arr[1].'.Fight</h2>';

    print "<p align='center'>X Character : ".$xChar->name."</p>";
    print '<p align="center">Comics : '.$xChar->comics->available.' Stories : '.$xChar->stories->available.' Events : '.$xChar->events->available.' Series : '.$xChar->series->available.'</p>';
    print '<p align="center"><img src="'.$xChar->thumbnail->path.'/portrait_medium.'.$xChar->thumbnail->extension.'"></p>';
    print "<p align='center'>Y Character : ".$yChar->name."</p>";
    print '<p align="center">Comics : '.$yChar->comics->available.' Stories : '.$yChar->stories->available.' Events : '.$yChar->events->available.' Series : '.$yChar->series->available.'</p>';
    print '<p align="center"><img src="'.$yChar->thumbnail->path.'/portrait_medium.'.$yChar->thumbnail->extension.'"></p>';
    print '<p align="center">'.$fight->round1.'</p>';
    print '<p align="center">'.$fight->round2.'</p>';
    print '<p align="center">'.$fight->round3.'</p>';
    print '<p align="center">'.$fight->round4.'</p>';

    print '<h3 align="center">'.getCharInDB_withID($db,$fight->winner_id)->hero_name.' Wins The Fight.</h3>';

    ?>
</p>

<form align='center' action="index.php" method="post">
    <p><input type="submit" value="Return To Main Page" content=""></p>
</form>


</body>
</html>
