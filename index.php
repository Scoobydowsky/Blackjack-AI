<?php
require 'vendor/autoload.php';
/*PYTANIA DO PRZEMA
* jaka skutecznośc ai <60% graniczy z cudem
*  modyfikacja zasad czyt -> blackjack europejski
 * Zestaw do nauki uproszczony
 * uproszczone decyzje dobierz kartę/wstrzymaj się
 * czy jezeli nie uda sie przebudować mozna wrócić do wersji 1.0 (niedoskonałej od ~30 % skuteczności do 50%
*/
/*VARS*/
const STATUS_WON = 'WON';
const STATUS_LOSE = 'LOSE';
const STATUS_DRAW = 'TIE';
const DRAW_CARD = 'DRAW CARD';
const HOLD = 'HOLD';
$counterGameWon = 0;
$counterGameLose = 0;
$counterGameTie = 0;
/*CONFIG */
$gamesToPlay = 100 ; // ilośc gier do rozegrania
$clrScrAfterGame = 1 ; //czyśc ekran po każdej rozegranej grze
$learnMode = 0; //tryb uczenia na podstawie tabeli podstawowej
$test = 1; //pokazuj wiecej informacji
$layout = new \BlackjackAi\Layout();

for($game= 1; $game <= $gamesToPlay; $game++){
    ($clrScrAfterGame == 1 ) ? system("clear"): " ";
    $layout->head($game);
    //rozdaj po karcie
    $dealer = new \BlackjackAi\Deck();
    $player = new \BlackjackAi\Deck();
    //gracz dobierz kartę
    $player->drawCard();
    //podlicz pkt
    $dealerPts = $dealer->countCards();
    $playerPts = $player->countCards();
    //pokaż ręke dealera
    $layout->showCards(0,$dealer);
    //niejawnie pobieraj karty dealera dopoki osiągną >= 17 pts
    do{
        $dealer->drawCard();
        $hiddenDealerPts= $dealer->countCards();
        ($test === 1) ? $layout->TestDealerPtsStatus($hiddenDealerPts) : "";//tylko do testów ujawnia prawdziwą ilość punktów
    }while($hiddenDealerPts < 17);

    //pokaż ręke gracza
    $layout->showCards(1, $player);
    $decision = $player->doDrawCardTest($playerPts, $dealerPts);
    echo PHP_EOL.$decision.PHP_EOL;
    if($decision === DRAW_CARD){
        echo 'Dobieram kartę';
        $player->drawCard();
        $playerPts = $player->countCards();
        $layout->showCards(1, $player);
    }

    //wykonuj to dopóki zmienna "decision" nie bedzie ustawiona na stałą HOLD albo nie przeburstuje (czyli powyżej 21)

    do{
        $decision = $player->doDrawCardTest($playerPts, $dealerPts);
        if($decision === HOLD){
            break;
        }
         //zaczytaj json w zalezoności czy test czy zwykła gra jezeli nie ma danych wykorzystaj funkcję rand
        if($test === 1){
            if($decision === HOLD){
                break;
            }else{
                $player->drawCard();
                $playerPts= $player->countCards();
            }
            try{
                //zestaw do nauki ~60% skuteczności
                $decision = $player->doDrawCardTest($playerPts, $dealerPts);
            }catch (Exception $e){
                echo $e->getMessage();
            }
        }else{
         //zestaw ai sktueczność nie znana
            //wyciąganie wniosków na podstawie poprzednich gier i dobierań kart
            //poprzednie gry z identyczną sytuacją
        }
        PHP_EOL;
        PHP_EOL;
        echo $decision;
        PHP_EOL;
        PHP_EOL;
        $layout->showCards(1,$player);

    }while($decision === DRAW_CARD && $playerPts <= 21);
    //sprawdzanie kto wygrał

    /* PRZYPADKI
     * gracz = dealer  && gracz <=21 - tie x
     * gracz = dealer  && gracz >=22 - lose x
     * gracz > dealer && gracz <= 21 - won x
     * gracz > dealer && gracz >= 22 - lose x
     * gracz < dealer && gracz <=21 && dealer <=21 -lose x
     * gracz < dealer && gracz >=22 && dealer >=22 -lose
     * gracz < dealer && gracz <=21 && dealer >=22 -won
     */
    if($playerPts === $hiddenDealerPts && $playerPts <=21){
        $status = STATUS_DRAW;
    }elseif($playerPts === $hiddenDealerPts && $playerPts >=22){
        $status = STATUS_LOSE;
    }elseif ($playerPts > $hiddenDealerPts && $playerPts <= 21){
        $status = STATUS_WON;
    }elseif ($playerPts > $hiddenDealerPts && $playerPts >= 22){
        $status = STATUS_LOSE;
    }elseif ($playerPts < $hiddenDealerPts && $playerPts <= 21 && $hiddenDealerPts <= 21){
        $status = STATUS_LOSE;
    }elseif ($playerPts < $hiddenDealerPts && $playerPts >= 22 && $hiddenDealerPts >= 22){
        $status = STATUS_LOSE;
    }elseif ($playerPts < $hiddenDealerPts && $playerPts <= 21 && $hiddenDealerPts >= 22){
        $status = STATUS_WON;
    }
    echo "Punkty Dealera {$hiddenDealerPts} |VS| Punkty Gracza {$playerPts}".PHP_EOL;
    $layout->EndGameStatus($status);

    //po grze w przypadku pętli podliczaj gry
    if($status === STATUS_WON){
        $counterGameWon++;
    }elseif ($status=== STATUS_LOSE){
        $counterGameLose++;
    }else{
        $counterGameTie++;
    }
}
$layout->EndGamesSummary($counterGameWon,$counterGameLose,$counterGameTie,$game);
