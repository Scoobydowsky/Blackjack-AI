<?php


class GameAssisster {
    public int $gamePTS;
    public string $gameStatus;

    public function __Construct(int $pts , string $status){
        $this->gamePTS = $pts ;
        $this->gameStatus = $status;
    }

    public function saveLog($pts , $status){
        //TODO zrobić zapisywanie do json
        $file =file_get_contents('src/games.json' );
        $oldTable = json_decode($file , true);
        $newContentTable = [ "pts" => $pts , "status" => $status];
        $oldTable[] = $newContentTable ;
        file_put_contents('src/games.json',json_encode($oldTable) ,);
        return  "Zapisuje do json ptk: {$this->gamePTS}  status: {$this->gameStatus}" ;
    }
}
