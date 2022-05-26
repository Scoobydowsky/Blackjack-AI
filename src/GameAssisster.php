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
    function readDrawData ($aiPts){
        $drawAccidents = 0 ;
        $moreAccidents = 0 ;
        $lessAccidents = 0 ;
        $drawDataFile = file_get_contents('src/draw.json');
        $drawDataMatrix = json_decode($drawDataFile, true);
        foreach ($drawDataMatrix as ['pts' => $pts, 'decision'=> $decision]){
            if($aiPts == $pts ){
                $drawAccidents++;
            }
            if ($aiPts > $pts) {
                $moreAccidents++;
            }
            if ($aiPts < $pts && $decision == HOLD) {
                $lessAccidents++;
            }
        }
        $count_prof = $drawAccidents /  ($drawAccidents + $moreAccidents + $lessAccidents) ;
        if ($count_prof > 0.8 ){
            return DRAW_CARD;
        }else{
            return HOLD ;
        }

    }
}

