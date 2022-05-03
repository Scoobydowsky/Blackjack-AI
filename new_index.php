<?php

const STATUS_WON = 'WON' ;
const STATUS_LOSE = 'LOSE';
const STATUS_DRAW = 'DRAW';
$wonTURN = 0;
$loseTURN = 0;


require 'vendor/autoload.php';
system("clear");
//rozdaj po dwie karty
$graczAI = new Deck();
$dealerAI= new Deck();
//wyswietl info
layoutHead();
//Zakładamy ze dealer pobiera tylko dwie karty
//$dealerAI ->drawCard();
//pokaż karty dealera i policz jego punkty
layoutDealerCards();
$dealerAI->getCards();
$dealerPTS = $dealerAI->countCards();
layoutDealerSumCards($dealerPTS);
//pokaż karty AI i policz jego punkty
layoutAiCards();
$graczAI->getCards();
$aiPTS = $graczAI->countCards();
layoutSumCards($aiPTS);
//pokaż wygrane przegrane i remisy
layoutDecision();
$wonGames= $graczAI->countWon($aiPTS);
$lossGames = $graczAI->countLoss($aiPTS);
$drawGames = $graczAI->countDraw($aiPTS);
layoutStats($wonGames ,$lossGames , $drawGames);
//wnioskowanie
$decision = $graczAI->makeDecisionImproved($wonGames , $lossGames);
do {
    layoutAiDecision($decision);
    PHP_EOL;
    if ($decision === DRAW_CARD) {
        layoutDrawedCard($graczAI->drawCard());

        layoutAiCards();
        $graczAI->getCards();
        $aiPTS = $graczAI->countCards();
        layoutSumCards($aiPTS);
//pokaż wygrane przegrane i remisy
        layoutDecision();
        $wonGames= $graczAI->countWon($aiPTS);
        $lossGames = $graczAI->countLoss($aiPTS);
        $drawGames = $graczAI->countDraw($aiPTS);
        layoutStats($wonGames ,$lossGames , $drawGames);
//wnioskowanie
        $decision = $graczAI->makeDecisionImproved($wonGames , $lossGames);
    } else {
        echo "================================================".PHP_EOL;
        break;
    }
} while ($decision == DRAW_CARD && $aiPTS < 21);
//pokaż punkty Ai i dealera
layoutShowAiAndDealerPTS($aiPTS , $dealerPTS);
//wylicz kto wygrał

//ogłoś wygraną
//zapisz dane do json