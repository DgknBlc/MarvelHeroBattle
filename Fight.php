<?php

class Fight
{

    public $xChar;
    public $yChar;

    public $winner;

    public $round = array();

    private $actions = array(
        "slams", "kicks", "punches", "drop-kicks", "smashes", "shots", "headshots", "deceives", "curses", "makes confession to",
        "HOUDKENs", "stabs", "slashs", "crushes", "throw a bomb at", "seduces", "sets fire on", "trolls"
        );



    public function __construct($xChar, $yChar)
    {
        $this->xChar = $xChar;
        $this->yChar = $yChar;
    }

    function fight($round, $fightCounter){

        $xChar = $this->xChar;
        $yChar = $this->yChar;

        print '<h2 align="center">Round-'.$round.':'.$fightCounter.'.Fight</h2>';

        print "<p align='center'>X Character : ".$xChar->name."</p>";
        print '<p align="center">Comics : '.$xChar->comics->available.' Stories : '.$xChar->stories->available.' Events : '.$xChar->events->available.' Series : '.$xChar->series->available.'</p>';
        print '<p align="center"><img src="'.$xChar->thumbnail->path.'/portrait_medium.'.$xChar->thumbnail->extension.'"></p>';
        print "<p align='center'>Y Character : ".$yChar->name."</p>";
        print '<p align="center">Comics : '.$yChar->comics->available.' Stories : '.$yChar->stories->available.' Events : '.$yChar->events->available.' Series : '.$yChar->series->available.'</p>';
        print '<p align="center"><img src="'.$yChar->thumbnail->path.'/portrait_medium.'.$yChar->thumbnail->extension.'"></p>';


        $arr = array();

        $arr[0] = $this->compare($xChar->comics->available, $yChar->comics->available);
        $arr[1] = $this->compare($xChar->stories->available, $yChar->stories->available);
        $arr[2] = $this->compare($xChar->events->available, $yChar->events->available);
        $arr[3] = $this->compare($xChar->series->available, $yChar->series->available);

        $result = array_sum($arr);

        foreach ($arr as $item){
            switch ($item){
                case 0 :
                    array_push($this->round,"Both misses their attacks.");
                    break;
                case 1 :
                    $attack = $this->actions[rand(0,count($this->actions)-1)];
                    array_push($this->round,$yChar->name." ".$attack." ".$xChar->name.".");
                    break;
                case -1:
                    $attack = $this->actions[rand(0,count($this->actions)-1)];
                    array_push($this->round,$xChar->name." ".$attack." ".$yChar->name.".");
                    break;
            }
            print '<p align = "center">'.$this->round[count($this->round)-1].'</p>';
        }

        $contenders = array($xChar,$yChar);
        if($result > 0){
            $txt = $yChar->name." Wins The Fight.";
            $this->winner = $yChar;
        }elseif ($result < 0){
            $txt = $xChar->name." Wins The Fight.";
            $this->winner = $xChar;
        }else{
            $i = rand(0,1);
            $this->winner = $contenders[$i];
            $txt = "It's a TIE. Selecting Random Winner";
        }

        print '<h3 align="center">'.$txt.'</h3>';

    }

    function compare($x, $y){
        if($x > $y){
            return -1;
        }elseif ($x < $y){
            return 1;
        }
        return 0;
    }

}