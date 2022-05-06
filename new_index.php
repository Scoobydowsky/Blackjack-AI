<?php
/*TODO
 * PRZEBUDOWA WNIOSKOWANIA
 * -> POBIERA DANE DODATKOWO Z DRAW JSON (który przechowuje informacje o poprzednich pobraniach kart)
 * dzieki któremu ai zacznie unikać burst'a ( ai > 21)
 * ->dodanie danych do games json (w chwili obecnej jest ilosć pkt ai i status wygranej) musimy dodać
 *  +ilosc pkt dealera
 *  +jaką decyzje podjęła AI w tamtej grze
 * mozliwe ze zamiast dodawać to do games json powinniśmy to dodać do decision json na którym to ai bedzie wnioskować czy dobierać czy nie
 */
const STATUS_WON = 'WON' ;
const STATUS_LOSE = 'LOSE';
const STATUS_DRAW = 'DRAW';
$wonTURN = 0;
$loseTURN = 0;


require 'vendor/autoload.php';
for($i =0 ; $i < 10 ; $i++){
    system("clear");
    echo "PRÓBA : {$i}".PHP_EOL;
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
    echo PHP_EOL;
    if ($decision === DRAW_CARD) {
        layoutDrawedCard($graczAI->drawCard());
        echo PHP_EOL;
        layoutAiCards();
        $graczAI->getCards();
        $aiPTS = $graczAI->countCards();
        echo PHP_EOL;
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
//sprawdź czy ai wygrało/zemisowało/przegrało
if($aiPTS > $dealerPTS && $aiPTS <= 21){
    $status = STATUS_WON;
}elseif ($aiPTS > $dealerPTS && $aiPTS > 21){
    $status = STATUS_LOSE;
}elseif ($aiPTS == $dealerPTS && $aiPTS > 21){
    $status = STATUS_LOSE;
}elseif ($aiPTS == $dealerPTS && $aiPTS < 21){
    $status = STATUS_DRAW;
}elseif($aiPTS < $dealerPTS && $dealerPTS > 21){
    $status = STATUS_WON;
}elseif($aiPTS < $dealerPTS && $dealerPTS < 21){
    $status = STATUS_LOSE;
}
//ogłoś wygraną
layoutStatus($status);
//zapisz dane do json

    //TODO dodać wartość kart dealera oraz jaką decyzje podjeliscie
$game = new GameAssisster($aiPTS , $status);
echo $game->saveLog($aiPTS,$status);
//Statystyki do uczenia
if($status == STATUS_WON){
    @$wonTURN++;
}else{
    @$loseTURN++;
}

}
echo "================================================".PHP_EOL;
echo "statystyki sesji:".PHP_EOL;
echo "Wygrane : {$wonTURN} Przegrane: {$loseTURN}".PHP_EOL;
echo "================================================".PHP_EOL;