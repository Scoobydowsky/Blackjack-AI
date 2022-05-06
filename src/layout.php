<?php
const DRAW_CARD = "dobierz kartę";
const HOLD = "pas" ;

function makeDecisionSimple() :string{
    $decision = (rand(1,2) == 1) ?  DRAW_CARD :  HOLD;
    return  $decision ;
}


function layoutHead(){
    ECHO "ROZDANIE ". PHP_EOL;
    echo "==============". PHP_EOL ;
    echo "KARTY:". PHP_EOL ;
}
function layoutSumCards($pts){
    echo "==============".PHP_EOL ;
    echo "WYNIK KART: " .$pts . PHP_EOL ;
    echo "==============".PHP_EOL ;
}
function layoutDecision($decision){
    echo "==============".PHP_EOL ;
    echo "Decyzja: ".$decision. PHP_EOL ;
    echo "==============".PHP_EOL ;
}
function layoutStatus($status){
    Echo "STATUS gry: ". $status . PHP_EOL ;
    echo "==============".PHP_EOL ;
}
function layoutDrawedCard($karta){
    echo "Dobrano kartę: ".$karta. PHP_EOL ;
    echo "==============".PHP_EOL ;
}
function layoutDealerSumCards($dealerPts){
    echo '================'.PHP_EOL;
    echo "Dealer ma w ręce: {$dealerPts}".PHP_EOL ;

}
