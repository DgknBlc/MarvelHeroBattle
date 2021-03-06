<!DOCTYPE html>
<html lang="en">
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
<h2 class="ortalama">Marvel 64-Hero Tournament</h2>
<form class="ortalama" action="tournament.php" method="post">
    <p><input type="submit" value="New Hero Tournament" content=""></p>
</form>

<h2 class="ortalama">Tournament History</h2>

<form class='was-validated' align='center' action="history.php" method="get">
    <div class="form-floating" style="margin: 0 40% 0 40%; display: compact">
        <select class="form-select" required label="Default select example" name="t_id">
            <option value="">Select</option>
            <?php
            foreach ($tournamentsIDS as $id){
                print '<option value="'.$id.'">'.$id.'</option>';
            }
            ?>
        </select>
        <label for="floatingSelect" >Select a Tournament</label>
    </div>
    <br>
    <div class="row-auto">
        <button type="submit" class="btn btn-primary mb-3">Show</button>
    </div>
</form>

<h2 class="ortalama">Fight History</h2>

<form class='was-validated' align='center' action="fighthistory.php" method="get">
    <div class="form-floating" style="margin: 0 40% 0 40%; display: compact">
        <select class="form-select" required aria-label="Tournament Select" name="t_id">
            <option value="">Select</option>
            <?php
            foreach ($tournamentsIDS as $id){
                print '<option value="'.$id.'">'.$id.'</option>';
            }
            ?>
        </select>
        <label for="floatingSelect">Select a Tournament</label>
    </div>
    <br>
    <div class="form-floating" style="margin: 0 40% 0 40%; display: compact">
        <select class="form-select" required aria-label="Fight Select" name="fight_id">
            <option value="">Select</option>
            <?php
            for($i = 0 ; $i < 63; $i++){
                $arr = fightNo_toRound($i);
                print '<option value="'.($i).'">Round '.$arr[0].' '.'Fight '.$arr[1].'</option>';
            }
            ?>
        </select>
        <label for="floatingSelect">Select a Fight</label>
    </div>
    <br>
    <div class="row-auto">
        <button type="submit" class="btn btn-primary mb-3">Show</button>
    </div>
</form>

</body>

</html>
