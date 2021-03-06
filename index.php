<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 12/24/15
 * Time: 3:40 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$old_error_handler = set_error_handler("myErrorHandler", E_ALL);
register_shutdown_function('myShutdown');

class myException extends Exception {


    public function errorMessage(){

        $errorMsg = 'Auh!! '.$this->getMessage().', on line '.
            $this->getLine().' in '.$this->getFile().', is invalid.';

        return $errorMsg;
    }

}

function err(){

try {
    echo $r;
    throw new myException('Something wrong.');
    return (50 / $i);

}
catch (myException $e){
    echo 'Caught exception: ',  $e->errorMessage(), "\n";
}
finally{
        echo "Always executing!!!";
    }
};



echo err();
echo "text";

function myShutdown()
{
    $error = error_get_last();
    if ($error['type'] === E_ERROR) {

        $out = PHP_EOL. str_pad("[Error data]:",15). date("Y-m-d H:i:s") .PHP_EOL;

        ob_start();
        debug_print_backtrace(10);
        $out .= ob_get_contents();
        ob_end_clean();

        $ap = dirname ( __FILE__ ).DIRECTORY_SEPARATOR;
        file_put_contents($ap.'fatal.log', $out, FILE_APPEND);
    }
};



function myErrorHandler($errno, $errstr, $errfile, $errline){

    $out ='';
    switch ($errno) {

        case E_ERROR:
            $err_level = "ERROR";
            break;

        case E_WARNING:
            $err_level = "WARNING";
            break;

        case E_NOTICE:
            $err_level = "NOTICE";
            break;
        case E_USER_ERROR:
            $err_level = "My ERROR";
            break;

        case E_USER_WARNING:
            $err_level = "My WARNING";
            break;

        case E_USER_NOTICE:
            $err_level = "My NOTICE";
            break;

        default:
            $err_level = "Unknown error type: [$errno]";
            break;
    }


    $out = PHP_EOL. str_pad("[Error data]:",15). date("Y-m-d H:i:s") . PHP_EOL . str_pad("[Error type]:",15) .
        $err_level . PHP_EOL .str_pad("[Error]:",15) . $errstr . PHP_EOL.str_pad("[Error file]:",15) .
        $errfile . PHP_EOL.str_pad("[Error line]:",15) . $errline . PHP_EOL;

    ob_start();
    debug_print_backtrace(10);
    $out .= ob_get_contents();
    ob_end_clean();

    $ap = dirname ( __FILE__ ).DIRECTORY_SEPARATOR;
    file_put_contents($ap.'error.log', $out, FILE_APPEND);

};

