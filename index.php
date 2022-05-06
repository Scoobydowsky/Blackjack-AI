<?php

const STATUS_WON = 'WON' ;
const STATUS_LOSE = 'LOSE';
const STATUS_DRAW = 'DRAW';
$wonTURN = 0;
$loseTURN = 0;


require 'vendor/autoload.php';
/*
 * 2-10 wartosci
 * krol 10
 * walet 10
 * dama 10
 * as 1 albo 11
 *
 */
/*
 * 1. KOMPUTER POBIERA 2 KARTY -> done
 * 2. KOMPUTER LICZY ICH WARTOŚĆ
 * 3. KOMPUTER PODEJMUJE DECYJZE CZY POBRAĆ KART
 *  a) komputer pasuje
 *  b) komputer dobiera kartę
 * 4.
 *  a) przeliczamy czy "gracz" ma wiecej niż bankier
 *      a.a) jezeli ma wiecej niz bankier a  < 21 to WYGRANA
 *      a.b) jezeli ma równo jak bankier to WYGRANA
 *      a.c) jezeli ma mniej niż bankier to PRZEGRANA
 *      a.d) jezeli ma powyzej 21 to PRZEGRYWA nieważne ile ma bankier
 *  b) dobieramy kartę i wracamy do 3 PKT
 */
//for load more data switch $i < 1 to more ex. $i < 100 for 100 test ;
for($i =0 ; $i < 1  ; $i++){
    echo PHP_EOL;
    layoutHead();
    $graczAI = new Deck();
    $dealerAI = new Deck();
    $graczAI->getCards();
    echo PHP_EOL;
    $pts = $graczAI->countCards();
    $dealerPts = $dealerAI->countCards();
    layoutSumCards($pts);
    $dealerAI->drawCard();
    $dealerPts =$dealerAI->countCards();
    $dealerAI->getCards();


    $decision = $graczAI->makeDecision($pts);

    do {
        layoutAiDecision($decision);
        if ($decision === 'dobierz kartę') {
            layoutDrawedCard($graczAI->drawCard());
            $pts = $graczAI->countCards();
            layoutSumCards($pts);
            $decision = $graczAI->makeDecision($pts);
        } else {
            break;
        }
    } while ($decision == 'dobierz kartę' && $pts < 21);
    layoutDealerSumCards($dealerPts);
//$status = (rand(1,2) == 1) ?  "wygrana" :  "przegrana";
    if ($pts > 21) {
        echo 'burst' . PHP_EOL;
        $status = STATUS_LOSE;
    } elseif ($pts === 21) {
        echo "Blackjack" . PHP_EOL;
        $status = STATUS_WON;
    }elseif($pts < 21 && $dealerPts > 21){
        $status = STATUS_WON;
    }
    elseif ($pts < 21 && $pts > $dealerPts) {
        $status = STATUS_WON;
    } elseif ($pts < 21 && $pts < $dealerPts) {
        $status = "LOSE";
    }elseif($pts < 21 && $pts === $dealerPts){
        $status = STATUS_DRAW ;
    }
    else {
        $status = STATUS_LOSE;
    }
    layoutStatus($status);
    if($status == STATUS_WON){
        @$wonTURN++;
    }else{
        @$loseTURN++;
    }


    $game = new GameAssisster($pts, $status);
    echo PHP_EOL;
    echo $game->saveLog($pts, $status);

}
echo PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo "Wygrane : {$wonTURN} Przegrane: {$loseTURN}";