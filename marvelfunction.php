<?php

function getCharData($selected_index){
    $date = new DateTime();

    $timestamp = $date->getTimestamp();

    $APIKEY = "3b4657db9e4d200a918dc33b70308686";
    $SECRET_APIKEY = "295882f34802605de2ec197dbf8b90cef4948972";

    $md5 = hash("md5", $timestamp.$SECRET_APIKEY.$APIKEY);

    $url = "https://gateway.marvel.com:443/v1/public/characters?ts=$timestamp&apikey=$APIKEY&hash=$md5&offset=$selected_index&limit=1";

    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);

    $jsonData = json_decode($result);
    $char = $jsonData->data->results[0];

    curl_close ($ch);
    return $char;
}

function getCharDataFromName($name){
    $date = new DateTime();

    $timestamp = $date->getTimestamp();

    $APIKEY = "3b4657db9e4d200a918dc33b70308686";
    $SECRET_APIKEY = "295882f34802605de2ec197dbf8b90cef4948972";

    $md5 = hash("md5", $timestamp.$SECRET_APIKEY.$APIKEY);

    $tempname = str_replace(" ","%20",$name);

    $url = "https://gateway.marvel.com:443/v1/public/characters?ts=$timestamp&apikey=$APIKEY&hash=$md5&name=$tempname&offset=0";

    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);

    $jsonData = json_decode($result);
    $char = $jsonData->data->results[0];

    curl_close ($ch);
    return $char;
}

function getCharInDB($db, $name){
    $query = $db->prepare('SELECT * FROM heroes WHERE hero_name = :name');
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch(PDO::FETCH_OBJ);
}

function getCharInDB_withID($db, $id){
    $query = $db->prepare('SELECT * FROM heroes WHERE hero_id = :id');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_OBJ);
}

function getTournamentInDB_withID($db, $id){
    $query = $db->prepare('SELECT * FROM tournaments WHERE t_id = :id');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_OBJ);
}

function isCharExistsInDB($db, $name){
    $query = $db->prepare('SELECT EXISTS(SELECT 1 FROM heroes WHERE hero_name = :name)');
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_BOTH);
    if($res[0] == true){
        return true;
    }
    return false;
}

function insertCharIntoDB($db, $name, $info){
    $query = $db->prepare('INSERT INTO heroes(hero_name, hero_info)	VALUES (:name,:info);');
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':info', $info, PDO::PARAM_STR);
    $res = $query->execute();
    return $res;
}

function getTournamentsFromDB($db){
    $query = $db->prepare('SELECT * FROM tournaments;');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
}

function getFightsFromDB($db, $id){
    $query = $db->prepare('SELECT * FROM fights WHERE t_id = :t_id;');
    $query->bindParam(':t_id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
}

function fightNo_toRound($number){

    $fightCounter = 1;
    $roundCounter = 1;
    $limit = 32;

    for($i = 1 ; $i <= $number; $i++){

        $fightCounter++;

        if($fightCounter > $limit){

            $roundCounter++;
            $fightCounter = 1;
            $limit /= 2;

        }

    }

    return array($roundCounter,$fightCounter);
}
