<?php namespace Codecheck;

$REQUEST_URL = 'http://challenge-server.code-check.io/api/recursive/ask?';
$MEMO = array();
$SEED = null;
function run ($argc, $argv)
{
    if(!empty($argv)){
        if(isset($argv[0]) && isset($argv[0])){
            if($argv[1] == 0){
                echo 1;
            }else if($argv[1] == 2){
                echo 2;
            }else{
                global $SEED;
                $SEED = $argv[0];
                echo f($argv[1]);
            }
        }
    }else{
        echo 'Missing argumentr';
    	exit(1);
    }

}

function askServer($n){
    global $MEMO,$REQUEST_URL,$SEED;
    $res = file_get_contents($REQUEST_URL.'seed='.urlencode($SEED).'&n='.urlencode($n));
    $result = json_decode($res);
    $result = (object)$result;
    $MEMO[$n] = $result->result;
    return $result->result;
}

function f($n){
    global $MEMO;
    if($n == 0){
        return 1;
    }else if($n == 2){
        return 2;
    }
    if(isset($MEMO[$n])){
    	return $MEMO[$n];
    }
	if($n % 2 == 0){
        return (f($n - 1) + f($n - 2) + f($n - 3) + f($n - 4));
    }else{
        return askServer($n);
    }
}