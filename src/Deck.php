<?php


class Deck {
    public $card = ['2',"3","4","5","6","7","8","9","10","walet", 'as' ,"dama","krol"];
    public $playerCards = [];
    public function __Construct() {
        for ( $i = 0; $i < 2 ; $i++){
            $this->playerCards[$i] = $this->card[rand(0,12)] ;
        }
    }
    public function getCards(){
        foreach ($this->playerCards as $playerCard){
            echo $playerCard . PHP_EOL;
        }
    }
    public function countCards(){
        $pts = 0 ;
        foreach ($this->playerCards as $playerCard){
            $cardValue = $playerCard;
            if (in_array($cardValue, ['walet', 'dama', 'krol'])) {
                $cardValue = 10;
            }
            //TODO
            elseif ($cardValue === 'as') {
                $cardValue = $pts > 10 ? 1 : 11;
            }
            $pts += $cardValue;
        }
        return $pts;
    }
    public function drawCard(){
        $this->playerCards[count($this->playerCards) + 1] = $this->card[rand(0,12)] ;
        return $this->playerCards[count($this->playerCards)];
    }
    public function drawDealerCard(){
        $this->playerCards[count($this->playerCards) + 1] = $this->card[rand(0,12)] ;
    }
    public function makeDecision($game_pts){
         $wonProb = 0;
         $lossProb = 0;
        $file = file_get_contents('src/games.json' );
        $oldTable = json_decode($file , true);
        foreach (@$oldTable as ['pts' => $pts, 'status' => $status]){
            if ($game_pts === $pts){
                if($status === STATUS_WON){
                    $wonProb++ ;
                }elseif($status === STATUS_LOSE){
                    $lossProb++;
                }else{

                }
            }
            $prob = $wonProb - $lossProb ;
            if($prob < 0){
                return DRAW_CARD;
            }else{
                return HOLD;
            }
        }
    }

}
