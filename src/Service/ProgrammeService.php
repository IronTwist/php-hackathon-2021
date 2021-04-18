<?php

namespace App\Service;

class ProgrammeService{

    public function checkDateTimeIntersection($dataListOfRoom, $newStartDatetimeCheck, $newEndDatetimeCheck): string
    {   
        //TODO Check if dates intersect
        $confirm = false;
        //Check provided data
        // dump($dataListOfRoom); 
        // dump($newStartDatetimeCheck); 
        // dump($newEndDatetimeCheck); die;
        
        foreach($dataListOfRoom as $dataOfList){
            //TODO Check if $confirm = true -> Error
            
        }

        

        return $confirm;
    }
}