<html>
<body>
<?php

$t_id = $_GET["t_id"];

?>

<h1 align="center"><?php print $t_id.". Tournament's Record";?></h1>

<?php
include 'marvelfunction.php';

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

$fights = getFightsFromDB($db, (int)$t_id);
$i = 1;
?>
<table align="center" border= "1px solid black">
    <tr>
        <td align='center'><b>X Char</b></td>
        <td align='center'><b>Y Char</b></td>
        <td align='center'><b>Winner Char</b></td>
        <td align="center">Choose</td>
    </tr>
    <?php
    foreach ($fights as $fight){
        print "<tr align='center'>";
        print '<td align="center">'.$i++.'</td>';
        print '<td align="center">'.getCharInDB_withID($db,$fight->xfighter_id)->hero_name.'</td>';
        print '<td align="center">'.getCharInDB_withID($db,$fight->yfighter_id)->hero_name.'</td>';
        print '<td align="center"><b>'.getCharInDB_withID($db,$fight->winner_id)->hero_name.'</b></td>';
        print "</tr>";
    }
    ?>
</table
<?php

$currentT = getTournamentInDB_withID($db,(int)$t_id);
$winnerName = getCharInDB_withID($db,$currentT->t_winner)->hero_name;
$marvelChar = getCharDataFromName($winnerName);

?>
<br>
<h3 align="center"><?php print (int)$t_id.'. Tournament\'s Winner is '.$winnerName ?></h3>;
<p align="center"><?php print '<img src="'.$marvelChar->thumbnail->path.'/portrait_medium.'.$marvelChar->thumbnail->extension.'">' ?> </p>

<form align='center' action="index.php" method="post">
    <p><input type="submit" value="Return To Main Page" content=""></p>
</form>

</body>
</html>
