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
// todo przerzucić ten fragment kodu do autoloadera
class Deck {
    public $card = ['2',"3","4","5","6","7","8","9","10","walet","dama","krol"];
    public $playerCards = [];
    public function __Construct() {
        for ( $i = 0; $i > 2 ; $i++){
          $this->playerCards[$i] = $this->card[rand(0,11)] ;
          echo $this->playerCards[$i] . PHP_EOL ;
        }
    }
    public function getCards(){
        foreach ($this->playerCards as $playerCard){
            var_dump($this->playerCards);
        }
    }

}


function makeDecisionSimple() :string{
    $decision = (rand(1,2) == 1) ?  "dobierz kartę" :  "pas";
    return  $decision ;
}


class GameAssisster {
    public int $gamePTS;
    public string $gameStatus;

    public function __Construct(int $pts , string $status){
        $this->gamePTS = $pts ;
        $this->gameStatus = $status;
    }

    public function saveLog(){
        //TODO zrobić zapisywanie do json
     return  "Zapisuje do json ptk: {$this->gamePTS}  status: {$this->gameStatus}" ;
    }
}
function layoutHead(){
    ECHO "ROZDANIE ". PHP_EOL;
    echo "==============". PHP_EOL ;
    echo "KARTY:". PHP_EOL ;
    echo "==============". PHP_EOL ;
}
function layoutSumCards($pts){
    echo "==============".PHP_EOL ;
    echo "WYNIK KART: " .$pts . PHP_EOL ;
    echo "==============".PHP_EOL ;
}
function layoutDecision(){
    echo "==============".PHP_EOL ;
    echo "Decyzja: ".makeDecisionSimple(). PHP_EOL ;
    echo "==============".PHP_EOL ;
}
function layoutStatus($status){
    Echo "STATUS gry: ". $status . PHP_EOL ;
    echo "==============".PHP_EOL ;
}

layoutHead();
$karty = new Deck();
$karty->getCards();
echo PHP_EOL ;

/*if (is_int($kartaPierwsza)){
    // przypadek karta 2-10
}elseif (){
    //przypadek walet
}elseif{
    //przypadek dama
}elseif (){
    //przypadek krol
}else{
    //przypadek as
    if(){
        //przypadek as gdy suma normalnie by była powyżej 21
        //np karta 10 + 2 + as (liczony jako normanie 11) = 23
        // licz as jako 1
        //np 10 + 2 + as ( liczony jako 1) = 13
    }else{
        //przypadek gdy suma normalnie jest ponizej 21
        //np karta 7 + 2 + as (liczony jako normanie 11) = 20
    }
}*/
echo PHP_EOL ;
$pts = 10 ;
layoutSumCards($pts);
//todo zmienić na podejmowanie decyzji przez ai
layoutDecision();
$status = (rand(1,2) == 1) ?  "wygrana" :  "przegrana";
layoutStatus($status);

//todo zrzucić do json status gry -> pkt kart i status gry (wygrana/ przegrana)
$game = new GameAssisster($pts, $status);
echo PHP_EOL;
echo $game->saveLog($pts , $status);
