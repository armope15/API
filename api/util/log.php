<?php
/* class Log
{
    private $filelog;
    function __construct($path){
        $this->filelog = fopen($path , "a");
    }
    function wl($type , $message){ //Write Line
        $date = new DateTime();
        fputs(
            $this->filelog
            ,"[".$type."]"
            ."[". $date->format("d-m-y H:i:s")."]"
            . $message
            ."\n"
        );
    }
    function close()
    {
        fclose($this->filelog);
    }
} */

function wLog($type, $message, $ntabs = 1)
{
    $file = fopen("log.txt", "a");
    /*  if ($file === false){ 
        $json = [
            'status' => "ERROR",
            'result' => "NO SE HA ABIERTO EL LOG"
        ];
        echo json_encode($json , http_response_code($json["status"]));
        die();
    } */
    $tabs="";
    while ($ntabs > 0) {
        $tabs .= "\t";
        $ntabs--;
    }
    $date = new DateTime();
    if (in_array($type , [ "START" , "END" , "WARNING" , "ERROR" ])) {
        $tabs = "";
    }
    fputs(
        $file,
        $tabs
            . "[" . $type . "]"
            . "[" . $date->format("d-m-y H:i:s") . "]"
            . $message
            . "\n"
    );
    fclose($file);
}
