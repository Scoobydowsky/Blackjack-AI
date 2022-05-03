<?php
const DRAW_CARD = "Dobierz kartę";
const HOLD = "PAS" ;

function makeDecisionSimple() :string{
    $decision = (rand(1,2) == 1) ?  DRAW_CARD :  HOLD;
    return  $decision ;
}


function layoutHead(){
    echo "======================================".PHP_EOL;
    ECHO "ROZDANIE ". PHP_EOL;
    echo "======================================". PHP_EOL ;
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
    echo '======================================'.PHP_EOL;
    echo "SUMA KART DEALERA: {$dealerPts}".PHP_EOL ;

}
function layoutDealerCards($dealerCards) :string{
    echo "======================================".PHP_EOL;
    echo "RĘKA Dealera:".PHP_EOL;
    foreach ($dealerCards as $card ){
        echo "{$card} ";
    }
    return PHP_EOL;
}
function layoutInference($won , $loss, $draw){
    echo '=============='.PHP_EOL;
    echo 'Status o podobnych wynikach:'.PHP_EOL;
    echo "Wygrane: {$won}".PHP_EOL;
    echo "Przegrane: {$loss}".PHP_EOL;
    echo "Remisy*: {$draw}".PHP_EOL;
    echo "*remisy nie są brane pod uwagę przy wnioskowaniu".PHP_EOL;
    echo '=============='.PHP_EOL;
}
