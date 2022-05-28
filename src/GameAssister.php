<?php

class GameAssister
{
    public function saveToDrawJson($ptsAI , $ptsPlayer, $decision){
        $file = file_get_contents('src/draw.json');
        $newTable = json_decode($file,true);
        $newDrawTable = ['ptsAI' => $ptsAI, 'ptsPlayer'=> $ptsPlayer , 'status' => $decision];
        $newTable[] = $newDrawTable;
        file_put_contents('src/draw.json',json_encode($newTable),);
        return "Zapisuje do pliku draw.json ptsPlayer: {$this->ptsPlayer} decyzja: {$this->decision} ptsDealer: {$this->ptsAI}";
    }
}