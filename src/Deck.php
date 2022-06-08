<?php

namespace BlackjackAi;

use http\Exception;

class Deck
{
    public $card = ['2',"3","4","5","6","7","8","9","10","walet", 'as' ,"dama","krol"];
    public $playerCards = [];

    public function __Construct(){
        for ( $i = 0; $i < 1 ; $i++){
            $this->playerCards[$i] = $this->card[rand(0,12)] ;
        }
    }
    public function getCards(){
        foreach ($this->playerCards as $playerCard){
            echo "{$playerCard} ";
        }
        echo  PHP_EOL;
    }
    public function countCards():int{
        $pts = 0 ;
        foreach ($this->playerCards as $playerCard){
            $cardValue = $playerCard;
            if (in_array($cardValue, ['walet', 'dama', 'krol'])) {
                $cardValue = 10;
            }
            elseif ($cardValue === 'as') {
                $cardValue = $pts > 10 ? 1 : 11;
            }
            $pts += $cardValue;
        }
        return $pts;
    }

    public function countWonGamesInHistory($playerPTS) :float{
        $countWon = 0;
        $countLose = 0;
        $countDraw = 0;
        $file = file_get_contents('src/games.json' );
        $oldTable = json_decode($file , true);
        if(empty($oldTable)){

        }else{
        //count games with this same
            foreach (@$oldTable as ['ptsPlayer' => $pts, 'status' => $status]){
                //won games counter
                if ($playerPTS === $pts && $status === STATUS_WON){
                    $countWon++ ;
                }
                //lose games counter
                if ($playerPTS === $pts && $status === STATUS_LOSE){
                    $countLose++ ;
                }
                //draw games
                if ($playerPTS === $pts && $status === STATUS_DRAW){
                    $countDraw++ ;
                }
            }
        }
        //count prof
        if(($countWon + $countLose + $countDraw) === 0){
            $prof = 0;
        }else{
            $prof = $countWon / ($countWon + $countLose + $countDraw);

        }


        return $prof ;
    }

    public function drawCard(){
        $this->playerCards[count($this->playerCards) + 1] = $this->card[rand(0,12)] ;
        return $this->playerCards[count($this->playerCards)];
    }

    public function doDrawCard($currentAiPTS , $currentPlayerPTS):float{
        $countDraws = 0;
        $countHolds = 0;
        $file = file_get_contents('src/draw.json' );
        $drawTable = json_decode($file , true);
        if(empty($drawTable)){

        }else{
            foreach ($drawTable as ['ptsAI' => $ptsAI, 'ptsPlayer'=> $ptsPlayer , 'status' => $decision]){
                //count drawed status
                if($ptsAI == $currentAiPTS && $ptsPlayer == $currentPlayerPTS && $decision == \DRAW_CARD){
                    $countDraws++ ;
                }
                //count holded status
                if($ptsAI == $currentAiPTS && $ptsPlayer == $currentPlayerPTS && $decision == \HOLD){
                    $countHolds++;
                }
            }
        }
        if(($countHolds + $countDraws) === 0 ){
            $didDrawCard = 0 ;
        }else{
            $didDrawCard = $countHolds/($countHolds + $countDraws);
        }

        return $didDrawCard;
    }
    public function doDrawCardTest($currentPlayerPTS, $currentDealerPTS):string{
        //liczniki
        $counterDraws = 0;
        $counterHolds = 0;
        $file = file_get_contents('src/drawTest.json');
        $testDrawArray = json_decode($file, true);
        if(empty($testDrawArray)){
            throw new \Exception("Brak bazy Testowej");
        }else{
            foreach ($testDrawArray as ['ptsPlayer'=> $ptsPlayerArr, 'ptsDealer' => $ptsDealerArr, 'decision' => $decisionArr]){
                if(($ptsPlayerArr === $currentPlayerPTS) && ($currentDealerPTS === $ptsDealerArr) && ($decisionArr ===  'DRAW CARD')){
                    $counterDraws++;

                }elseif(($ptsPlayerArr === $currentPlayerPTS) && ($currentDealerPTS === $ptsDealerArr) && ($decisionArr ===  'HOLD')){
                    $counterHolds++;
                }else{

                }
            }
        }
        if($counterDraws === 1){
            $prob = DRAW_CARD;
        }else{
            $prob = HOLD;
        }
        return $prob;
    }
}