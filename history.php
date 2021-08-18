<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <style>

        .ortalama{
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        body{
            background-image: url("https://images3.alphacoders.com/100/1003231.jpg");
            background-size: cover;
            background-repeat: repeat-y;
        }

    </style>
    <title>Marvel Hero Battle</title>

</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php" style="margin: 0 auto 0 auto">
            <img src="http://assets.stickpng.com/images/585f9333cb11b227491c3581.png" alt="" width="85px" class="d-inline-block align-text-top">
            Marvel Hero Battle
        </a>
    </div>
</nav>

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
$i = 0;
?>
<table align="center" border= "1px solid black" bgcolor="white">
    <tr>
        <td align="center"><b>Fight Round</b></td>
        <td align='center'><b>X Char</b></td>
        <td align='center'><b>Y Char</b></td>
        <td align='center'><b>Winner Char</b></td>
    </tr>
    <?php
    foreach ($fights as $fight){
        $arr = fightNo_toRound($i);
        $i++;
        print "<tr align='center'>";
        print '<td align="center">'.'Round-'.$arr[0]." ".$arr[1].'. Fight</td>';
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
