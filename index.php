<?php

const STATUS_WON = 'WON' ;
const STATUS_LOSE = 'LOSE';

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
    echo PHP_EOL;
    layoutHead();
    $graczAI = new Deck();
    $dealerAI = new Deck();
    $graczAI->getCards();
    echo PHP_EOL;

    $pts = $graczAI->countCards();
    $dealerPts = $dealerAI->countCards();
    layoutSumCards($pts);
    $decisionDealer = $dealerAI->makeDecision($dealerPts);
    do {
        if ($decisionDealer === 'dobierz kartę') {
            $dealerPts = $dealerAI->countCards();
            $decisionDealer = $graczAI->makeDecision($dealerPts);
        } else {
            break;
        }
    } while ($decisionDealer == 'dobierz kartę' && $dealerPts < 21);

//TODO zmienić na podejmowanie decyzji przez ai
//$decision = makeDecisionSimple() ;
    $decision = $graczAI->makeDecision($pts);
//TODO jezeli komp chce dobrać kartę wyswietl i wykonaj kod
    do {
        layoutDecision($decision);
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
    } elseif ($pts < 21 && $pts > $dealerPts) {
        $status = STATUS_WON;
    } elseif ($pts < 21 && $pts < $dealerPts) {
        $status = "LOSE";
    } else {
        $status = STATUS_LOSE;
    }
    layoutStatus($status);

    $game = new GameAssisster($pts, $status);
    echo PHP_EOL;
    echo $game->saveLog($pts, $status);