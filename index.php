<?php
/* test mode -> using predefinment Deck funct where ai get on
 *  NO  |   PLAYER  |   DEALER  |   EXP DECISION    |   GAME STATUS
 *  1   |   21      |   10      |   HOLD            |   WON (BLACKJACK)
 */
$testModeOn = 0 ;
/*if($testModeOn === 0){
    include 'src/Deck.php';
}else{
    include 'src/DeckTest.php';
}*/
require 'vendor/autoload.php';
include 'src/Layout.php';
include 'src/Deck.php';
include 'src/GameAssister.php';
const STATUS_WON = 'WON';
const STATUS_LOSE = 'LOSE';
const STATUS_DRAW = 'TIE';

const DRAW_CARD = 'DRAW CARD';
const HOLD = 'HOLD';

$counterWon = 0;
$counterLose = 0;
$counterTie = 0;
//change this to play more games, learn ai
$games = 100 ;
//define you want to see all games in your console or only last
$clearCmdAfterOneGame = 0 ;

$setStatus = '' ;

for ($i= 0 ; $i < $games; $i++){
    system("clear");
    ($clearCmdAfterOneGame === 1) ? system("clear") : " " ;
    $gameNo = $i+1;
    $layout = new Layout();
    $gameAssister = new GameAssister();
    $layout ->head($gameNo);

    //rozdaj dwie karty
    $playerAI = new Deck\Deck();
    $dealerAI = new Deck\Deck();

    //show on screen
    $layout ->showCards(0, $dealerAI);
    $layout ->showCards(1, $playerAI);

    //przelicz punkty
    $dealerAIPTS= $dealerAI->countCards();
    $playerAiPts = $playerAI->countCards();


    //wyniki wnioskowania czy przerwać teraz grę, dobrać kartę
    @$prevGamesWon = $playerAI->countWonGamesInHistory($playerAiPts);
    @$drawCardsProof = $playerAI->drawCardProf($dealerAI ,$playerAiPts);

    $proofOFtwo = ($prevGamesWon + $drawCardsProof)/ 2 ;
    // decyzja co robi ai
    if ($proofOFtwo == 0.0){
        //brak danych o poprzednich grach wiec wykonaj to losowo
        $k = rand(1,50); // randomize effect of drawing card
        for($j =0 ; $j < $k ; $j++){
            $drawDecision = rand(1,2) ;
        }
    }else{
        if($proofOFtwo > 0.5){
            $setStatus = HOLD;
        }else{
            $setStatus = DRAW_CARD;
        }
        //TODO wyciagaj wnioski na podstawie wiedzy o poprzednich grach
    }

    if($drawDecision == 1){
        $decision = DRAW_CARD;
    }else{
        $decision = HOLD ;
    }
    $layout->showDecision($decision);
    do{
        //if ai make decision to hold escape
        if($decision === HOLD){
            break;
        }

        if($playerAiPts > 21 || $dealerAIPTS > 21) {
            //annouce player/ dealer loose
            break;
        }
        $gameAssister->saveToDrawJson($dealerAIPTS,$playerAiPts,$decision);


        $playerAI->drawCard();
        //TODO save to draw json

        //show on screen
        $layout ->showCards(0, $dealerAI);
        $layout ->showCards(1, $playerAI);

        //przelicz punkty
        $dealerAIPTS= $dealerAI->countCards();
        $playerAiPts = $playerAI->countCards();


        //wyniki wnioskowania czy przerwać teraz grę, dobrać kartę
        @$prevGamesWon = $playerAI->countWonGamesInHistory($playerAiPts);
        @$drawCardsProof = $playerAI->drawCardProf($dealerAI ,$playerAiPts);

        $proofOFtwo = ($prevGamesWon + $drawCardsProof)/ 2 ;
        // decyzja co robi ai
        if ($proofOFtwo == 0.0){
            //brak danych o poprzednich grach wiec wykonaj to losowo
            $k = rand(1,50); // randomize effect of drawing card
            for($j =0 ; $j < $k ; $j++){
                $drawDecision = rand(1,2) ;
            }
        }else{
            if($proofOFtwo > 0.5){
                $setStatus = HOLD;
            }else{
                $setStatus = DRAW_CARD;
            }
        }

        if($drawDecision == 1){
            $decision = DRAW_CARD;
        }else{
            $decision = HOLD ;
        }
        if($playerAiPts > 21){
            $setStatus = STATUS_LOSE ;
            break;
        }

        $layout->showDecision($decision);
    }while($drawDecision == 1);
    //check is burst by dealer
  if($dealerAIPTS > $playerAiPts && $dealerAIPTS <= 21 || $playerAiPts > 21 ){
      $setStatus = STATUS_LOSE;
  }
  if($dealerAIPTS < $playerAiPts && $playerAiPts <= 21 || $dealerAIPTS > 21){
      $setStatus = STATUS_WON ;
  }
  if($dealerAIPTS == $playerAiPts && ($dealerAIPTS && $playerAiPts) <= 21){
      $setStatus = STATUS_DRAW ;
  }
    $layout->EndGameStatus($setStatus);
    //save data in draw json



    /*
     //count winner and looser
     * if status = hold then save status in games
     *
     *
    */


    //sprawdz czy gra nie jest z góry wygrana


    @$gameAssister->saveGamesJson($dealerAIPTS,$playerAiPts,$setStatus);
    if($setStatus == STATUS_WON){
        $counterWon++;
    }elseif($setStatus == STATUS_LOSE){
        $counterLose++;
    }else{
        $counterTie++;
    }
}

echo "Wygrane {$counterWon} Przegrane {$counterLose}  REmisy {$counterTie}";
