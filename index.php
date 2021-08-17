<!DOCTYPE html>
<html>
<body>

<?php
include "marvelfunction.php";

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

$tournamentsIDS = array();
foreach (getTournamentsFromDB($db) as $item){
    array_push($tournamentsIDS,$item->t_id);
}

?>
<h1 align='center'>Marvel Hero Battle</h1>


<h2 align='center'>Marvel 64-Hero Tournament</h2>
<form align='center' action="tournament.php" method="post">
    <p><input type="submit" value="New Hero Tournament" content=""></p>
</form>

<h2 align='center'>Tournament History</h2>
<form align='center' action="history.php" method="get">
    <p>Choose a Tournament:</p>
    <?php
    foreach ($tournamentsIDS as $id){
        print '<input type="radio" name="t_id" value="'.$id.'" />'.$id.'';
    }
    ?>
    <p><input type="submit" value="Show" /></p>
</form>

<h2 align='center'>Fight History</h2>
<form align='center' action="fighthistory.php" method="get">
    <p>Choose a Tournament:</p>
    <?php
    foreach ($tournamentsIDS as $id){
        print '<input type="radio" name="t_id" value="'.$id.'" />'.$id.'';
    }
    ?>
    <p>Choose a Fight:</p>
    <p>Eliminations 32</p>
    <?php
    for($i = 1 ; $i <= 32; $i++){
        print '<input type="radio" name="fight_id" value="'.($i-1).'" />'. $i .'';
    }
    ?>
    <p>Eliminations 16</p>
    <?php
    for($i = 1 ; $i <= 16; $i++){
        print '<input type="radio" name="fight_id" value="'.($i+31).'" />'. $i .'';
    }
    ?>
    <p>Eighth-finals</p>
    <?php
    for($i = 1 ; $i <= 8; $i++){
        print '<input type="radio" name="fight_id" value="'.($i+47).'" />'. $i .'';
    }
    ?>
    <p>Quarter-finals</p>
    <?php
    for($i = 1 ; $i <= 4; $i++){
        print '<input type="radio" name="fight_id" value="'.($i+55).'" />'. $i .'';
    }
    ?>
    <p>Semi-finals</p>
    <?php
    for($i = 1 ; $i <= 2; $i++){
        print '<input type="radio" name="fight_id" value="'.($i+59).'" />'. $i .'';
    }
    ?>
    <p>Final</p>
    <?php
    for($i = 1 ; $i <= 1; $i++){
        print '<input type="radio" name="fight_id" value="'.($i+61).'" />'. $i .'';
    }
    ?>
    <p><input type="submit" value="Show" /></p>
</form>
</body>
</html>
