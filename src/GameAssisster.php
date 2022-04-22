<?php


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
