<?php
/* Zmiana zasad działania gry
 * krupier pobiera 1 kartę
 *  jezeli krupier ma >= 16 ptk to pobiera kartę jezeli 17=< sie wstrzmymuje
 * wykorzystujemy do uczenia tabelę strategii podstawowych
 */
$testModeOn = 0 ;
require 'vendor/autoload.php';

const STATUS_WON = 'WON';
const STATUS_LOSE = 'LOSE';
const STATUS_DRAW = 'TIE';

const DRAW_CARD = 'DRAW CARD';
const HOLD = 'HOLD';

$counterWon = 0;
$counterLose = 0;
$counterTie = 0;
//change this to play more games, learn ai
$games = 1 ;
//define you want to see all games in your console or only last
$clearCmdAfterOneGame = 0 ;

$setStatus = '' ;

for ($i= 0 ; $i < $games; $i++){
    system("clear");
    ($clearCmdAfterOneGame === 1) ? system("clear") : " " ;
    $gameNo = $i+1;
    $layout = new \Cos\Layout();
    $gameAssister = new \Cos\GameAssister();
    $layout ->head($gameNo);

    //rozdaj dwie karty
    $playerAI = new \Cos\Deck();
    $dealerAI = new \Cos\Deck();

    //show on screen
    $layout ->showCards(0, $dealerAI);
    $layout ->showCards(1, $playerAI);

    //przelicz punkty
    $dealerAiPTS= $dealerAI->countCards();
    $playerAiPts = $playerAI->countCards();


    //wyniki wnioskowania czy przerwać teraz grę, dobrać kartę
    $prevGamesWon = $playerAI->countWonGamesInHistory($playerAiPts); // hold
    $drawCardsProof = 1 - $playerAI->drawCardProf($dealerAiPTS ,$playerAiPts); // draw

    $proofOFtwo = ($prevGamesWon + $drawCardsProof)/ 2 ;

    if ($testModeOn === 0){
        if (!((int) $proofOFtwo)) {
            //brak danych o poprzednich grach wiec wykonaj to losowo
            $k = rand(1,50); // randomize effect of drawing card
            for($j =0 ; $j < $k ; $j++){
                $drawDecision = rand(1,2) ;
                if($drawDecision == 1){
                    $decision = DRAW_CARD;
                }else{
                    $decision = HOLD ;
                }
            }
        }else{
            if($proofOFtwo < 0.5){
                $decision = HOLD;

            }else{
                $decision = DRAW_CARD;
            }
        }
    }else{
        //TODO TRYB TESTU UZYWAJ STRATEGII PODSTAWOWEJ
    }
    // decyzja co robi ai



    $layout->showDecision($decision);
    do{
        //if ai make decision to hold escape
        if($decision === HOLD){
            break;
        }

        if($playerAiPts > 21 || $dealerAiPTS > 21) {
            //annouce player/ dealer loose
            break;
        }
        $gameAssister->saveToDrawJson($dealerAiPTS,$playerAiPts,$decision);


        $playerAI->drawCard();

        //show on screen
        $layout ->showCards(0, $dealerAI);
        $layout ->showCards(1, $playerAI);

        //przelicz punkty
        $dealerAiPTS= $dealerAI->countCards();
        $playerAiPts = $playerAI->countCards();


        //wyniki wnioskowania czy przerwać teraz grę, dobrać kartę
        $prevGamesWon = $playerAI->countWonGamesInHistory($playerAiPts);
        $drawCardsProof = 1 - $playerAI->drawCardProf($dealerAiPTS ,$playerAiPts);

        $proofOFtwo = ($prevGamesWon + $drawCardsProof)/ 2 ;
        // decyzja co robi ai
        if (!((int) $proofOFtwo)) {
            //brak danych o poprzednich grach wiec wykonaj to losowo
            $k = rand(1,50); // randomize effect of drawing card
            for($j =0 ; $j < $k ; $j++){
                $drawDecision = rand(1,2) ;
                    if($drawDecision == 1){
                        $decision = DRAW_CARD;
                    }else{
                        $decision = HOLD ;
                    }
                    if($playerAiPts > 21){
                        $setStatus = STATUS_LOSE ;
                        break;
                    }
            }
        }else{
            if($proofOFtwo > 0.5){
                $decision = HOLD;
            }else{
                $decision = DRAW_CARD;
            }
        }



        $layout->showDecision($decision);
    }while($drawDecision == 1);
    //check is burst by dealer
  if($dealerAiPTS > $playerAiPts && $dealerAiPTS <= 21 || $playerAiPts > 21 ){
      $setStatus = STATUS_LOSE;
  }
  if($dealerAiPTS < $playerAiPts && $playerAiPts <= 21 || $dealerAiPTS > 21){
      $setStatus = STATUS_WON ;
  }
  if($dealerAiPTS == $playerAiPts && ($dealerAiPTS && $playerAiPts) <= 21){
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


    @$gameAssister->saveGamesJson($dealerAiPTS,$playerAiPts,$setStatus);
    if($setStatus == STATUS_WON){
        $counterWon++;
    }elseif($setStatus == STATUS_LOSE){
        $counterLose++;
    }else{
        $counterTie++;
    }
}

echo "Wygrane {$counterWon} Przegrane {$counterLose}  REmisy {$counterTie}";
