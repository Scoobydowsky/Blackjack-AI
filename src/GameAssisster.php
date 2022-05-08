<?php


class GameAssisster {
    public int $gamePTS;
    public string $gameStatus;

    public function __Construct(int $pts , string $status){
        $this->gamePTS = $pts ;
        $this->gameStatus = $status;
    }

    public function saveLog($pts , $status) : string{
        $file =file_get_contents('src/games.json' );
        $oldTable = json_decode($file , true);
        $newContentTable = [ "pts" => $pts , "status" => $status];
        $oldTable[] = $newContentTable ;
        file_put_contents('src/games.json',json_encode($oldTable) ,);
        return  "Zapisuje do json ptk: {$this->gamePTS}  status: {$this->gameStatus}".PHP_EOL ;
    }

    public function saveLogDealer($ptsDealer, $statusDealer){
        $dealerFile = file_get_contents('src/dealer-games.json');
        $dealerTable = json_decode($dealerFile, true);
        $newContentTableDealer = ["pts" => $ptsDealer , "status" => $statusDealer];
        $dealerTable[] = $newContentTableDealer;
        file_put_contents('src/dealer-games.json',json_encode($dealerTable));

        return "Zapisuje do json dealera pkt {$ptsDealer} oraz status {$statusDealer}";
    }
    function saveDrawData($pts , $decision){
        $drawDataFile = file_get_contents('src/draw.json');
        $drawData = json_decode($drawDataFile,true);
        $newDataContent = ["pts"=> $pts , "Decision"=> $decision];
        $drawData[] = $newDataContent;
        file_put_contents('src/draw.json');
    }
    function readDrawData() : string {
        $drawDataFile = file_get_contents('src/draw.json')
    }
}
