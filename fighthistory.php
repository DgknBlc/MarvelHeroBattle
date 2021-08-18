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
    ?>

<div class="container">
    <div class="row">
        <div class="card" style="width: 10rem; margin: 0 auto 0 auto">
            <img src=<?php print '"'.$xChar->thumbnail->path.'/portrait_large.'.$xChar->thumbnail->extension.'"'?>class="card-img-top">
            <div class="card-body">
                <h5 class="card-title" align="center"><?php print $xChar->name ?></h5>
                <p class="card-text" align="center"><?php print 'Comics : '.$xChar->comics->available.' Stories : '.$xChar->stories->available.' Events : '.$xChar->events->available.' Series : '.$xChar->series->available ?></p>
            </div>
        </div>
        <div class="card" style="width: 20rem; margin: 0 auto 0 auto">
            <div class="card-body">
                <h3 class="card-title" align="center">Battle</h3>
                <p class="card-text" align="center"><?php print $fight->round1 ?></>
                <p class="card-text" align="center"><?php print $fight->round2 ?></>
                <p class="card-text" align="center"><?php print $fight->round3 ?></>
                <p class="card-text" align="center"><?php print $fight->round4 ?></>
                <h5 align="center"><?php print getCharInDB_withID($db,$fight->winner_id)->hero_name ?> Wins The Fight</h5>
            </div>
        </div>
        <div class="card" style="width: 10rem; margin: 0 auto 0 auto">
            <img src=<?php print '"'.$yChar->thumbnail->path.'/portrait_large.'.$yChar->thumbnail->extension.'"'?>class="card-img-top">
            <div class="card-body">
                <h5 class="card-title" align="center"><?php print $yChar->name ?></h5>
                <p class="card-text" align="center"><?php print 'Comics : '.$yChar->comics->available.' Stories : '.$yChar->stories->available.' Events : '.$yChar->events->available.' Series : '.$yChar->series->available ?></p>
            </div>
        </div>
    </div>
</div>


</p>

<form align='center' action="index.php" method="post">
    <p><input type="submit" value="Return To Main Page" content=""></p>
</form>


</body>
</html>
