<?php 
    function SendLog($message) { 
        $index = 1;
        $logFileName = "logs/log-" . $index . ".txt";

        while (file_exists($logFileName)) {
            $index++;
            $logFileName = "logs/log-" . $index . ".txt";
        }

        $myfile = fopen($logFileName, "w");
        fwrite($myfile, $message);
        fclose($myfile);
    }
?>