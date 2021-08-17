<!DOCTYPE html>
<html>
<body>


<?php
include 'marvelfunction.php';
include 'Fight.php';

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
<h1 align="center">MARVEL HERO BATTLE</h1>
<?php
$CHAR_SIZE = 1500;
$P_SIZE = 64;
$allChars = array();  //Char obj array
$winners = array();  //Temp Winner obj array
$participants = array();  //String names;
$fights = array();
$fightCounter = 1;
$round = 1;

print "<h4 align='center'>All Participants :</h4>";
for($i = 0; $i < $P_SIZE; $i++){
    $allChars[$i] = getCharData(rand(0,$CHAR_SIZE));
    $name = $allChars[$i]->name;
    $info = $allChars[$i]->description;
    $participants[$i] = $name;
    if(!isCharExistsInDB($db,$name)){
        $res = insertCharIntoDB($db,$name,$info);
    }
    print '<p align="center">'.$i+1 .':'.$name.'</p>';
}

$index = 0;
while(count($allChars) != 1){   //Fight Happens HERE
    $fight = new Fight($allChars[$index], $allChars[$index+1]);
    $fight->fight($round,$fightCounter);
    $fightCounter++;
    array_push($fights,$fight);
    array_push($winners,$fight->winner);
    $index += 2;
    if($index >= count($allChars)){
        $index = 0;
        $allChars = $winners;
        $winners = array();
        $fightCounter = 1;
        $round++;
    }
}

print '<h2 align="center">Tournament Winner is '.$allChars[0]->name.'</h2>';
print '<p align="center"><img src="'.$allChars[0]->thumbnail->path.'/portrait_large.'.$allChars[0]->thumbnail->extension.'"></p>';

$winner = getCharInDB($db,$allChars[0]->name);

$query = $db->prepare('INSERT INTO tournaments(t_winner) VALUES (:heroid);');
$query->bindParam(':heroid',$winner->hero_id, PDO::PARAM_INT);
$query->execute();

$query = $db->prepare('SELECT MAX (t_id) as max FROM tournaments;');
$query->execute();
$res = $query->fetch(PDO::FETCH_OBJ);
$t_id = $res->max;

for($i = 0; $i < count($fights); $i++){
    $x = getCharInDB($db,$fights[$i]->xChar->name);
    $y = getCharInDB($db,$fights[$i]->yChar->name);
    $win = getCharInDB($db,$fights[$i]->winner->name);
    $round = $fights[$i]->round;
    $query = $db->prepare('INSERT INTO public.fights(t_id, xfighter_id, yfighter_id, winner_id, round1,round2,round3,round4) VALUES (:t_id, :x, :y, :winner, :r1, :r2, :r3, :r4);');
    $query->bindParam(':t_id',$t_id, PDO::PARAM_INT);
    $query->bindParam(':x',$x->hero_id, PDO::PARAM_INT);
    $query->bindParam(':y',$y->hero_id, PDO::PARAM_INT);
    $query->bindParam(':winner',$win->hero_id, PDO::PARAM_INT);
    $query->bindParam(':r1',$round[0], PDO::PARAM_STR);
    $query->bindParam(':r2',$round[1], PDO::PARAM_STR);
    $query->bindParam(':r3',$round[2], PDO::PARAM_STR);
    $query->bindParam(':r4',$round[3], PDO::PARAM_STR);
    $query->execute();
}

?>
<h2 align='center'>Savaş/Turnuva Geçmişi</h2>
<form align='center' action="history.php" method="post">
    <p>Turnuva Seçiniz:</p>
    <?php
    foreach ($tournamentsIDS as $id){
        print '<input type="radio" name="tRadio" value="'.$id.'" />'.$id.'';
    }
    ?>
    <p><input type="submit" /></p>
</form>


<form align='center' action="index.php" method="post">
    <p><input type="submit" value="Return To Main Page" content=""></p>
</form>


</body>
</html>
