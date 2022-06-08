<?php

namespace BlackjackAi;
class Layout{
    function head($gameNo)
    {
        echo  PHP_EOL;
        echo "======================================".PHP_EOL;
        echo "GAME NO: $gameNo". PHP_EOL;
        echo  PHP_EOL;
    }
    function showCards($isPlayer,$cardsVar){
        echo  PHP_EOL;
        echo "======================================".PHP_EOL;
        echo  PHP_EOL;
        echo ($isPlayer == 1) ? "HAND AI PLAYER".PHP_EOL : "HAND AI DEALER" .PHP_EOL ;
        $cardsVar->getCards();
        echo  PHP_EOL;
        $this->countCard($cardsVar);
    }
    function countCard($deckVar){
        echo "Cards Sum(PTS): {$deckVar->countCards()}";
        echo  PHP_EOL;
    }
    function showDecision($decision){
        echo "======================================".PHP_EOL;
        echo "AI podjęło decyzje {$decision}".PHP_EOL;
    }
    function EndGameStatus($status){
        echo "======================================".PHP_EOL;
        echo "GAME OVER AI: {$status}".PHP_EOL;
    }
    function TestDealerPtsStatus($dealerPts):string{
        echo "======================================".PHP_EOL;
        echo "Punkty Dealera: {$dealerPts}".PHP_EOL;
        return " ";
    }
    function EndGamesSummary($won,$lose,$ties,$playedGames){
        $games = $playedGames - 1;
        echo "STATUS po {$games} grze/grach".PHP_EOL;
        echo "STOSUNEK WYGRANA/PRZEGRANA/REMIS: {$won}/{$lose}/{$ties}".PHP_EOL;
        $percentage = ($won / ($won + $lose))* 100;
        echo "% SKUTECZNOŚĆ(remisy są ignorowane): {$percentage} %".PHP_EOL;
    }
}
