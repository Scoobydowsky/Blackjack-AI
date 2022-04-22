<?php


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
 *      a.b) jezeli ma jezeli ma równo jak bankier to REMIS
 *      a.c) jezeli ma mniej niż bankier to PRZEGRANA
 *      a.d) jezeli ma powyzej 21 to PRZEGRYWA nieważne ile ma bankier
 *  b) dobieramy kartę i wracamy do 3 PKT
 */


echo PHP_EOL ;

layoutHead();
$graczAI = new Deck();
$graczAI->getCards();
echo PHP_EOL ;

$pts = $graczAI->countCards();

layoutSumCards($pts);
//todo zmienić na podejmowanie decyzji przez ai
$decision = makeDecisionSimple() ;
layoutDecision($decision);
//todo jezeli komp chce dobrać kartę wyswietl i wykonaj kod
if ($decision === 'dobierz kartę'){
    layoutDrawedCard($graczAI->drawCard());
    $pts = $graczAI->countCards();
    layoutSumCards($pts);

}
//$status = (rand(1,2) == 1) ?  "wygrana" :  "przegrana";
if($pts > 21){
    echo 'burst'.PHP_EOL;
    $status = "LOSE";
}elseif($pts === 21){
    echo "Blackjack".PHP_EOL;
    $status = "WON";
}elseif ($pts < 21 /* &&  Ai won */){
    $status = "WON";
}/*elseif ($pts < 21  &&  Ai lose ){
    $status = "LOSE";
}*/else {
    $status = "LOSE";
}
layoutStatus($status);

//todo zrzucić do json status gry -> pkt kart i status gry (wygrana/ przegrana)
$game = new GameAssisster($pts, $status);
echo PHP_EOL;
echo $game->saveLog($pts , $status);
