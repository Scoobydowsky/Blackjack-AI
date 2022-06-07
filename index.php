<?php
require 'vendor/autoload.php';

const STATUS_WON = 'WON';
const STATUS_LOSE = 'LOSE';
const STATUS_DRAW = 'TIE';

const DRAW_CARD = 'DRAW CARD';
const HOLD = 'HOLD';
/*CONFIG */
$gamesToPlay = 1 ;
$clrScrAfterGame = 1 ;
$learnMode = 0;


for($i= 0; $i <$gamesToPlay; $i++){
    ($clrScrAfterGame == 1 ) ? system("clear"): " ";
    //TODO podanie kart jezeli w trybie testów użyj klasy DESKTEST
        $player = new \BlackjackAi\Deck() ;
        $dealer = new \BlackjackAi\Deck() ;
    $dealerPts = $dealer->countCards();
    echo $dealerPts.PHP_EOL;
    do{
        $dealer->drawCard();
        $dealerPts = $dealer->countCards();
        echo $dealerPts.PHP_EOL;
    }while($dealerPts <=16);


}
