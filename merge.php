<?php
error_reporting(E_ALL & ~E_NOTICE);
$f = glob("*.csv");
//$f = ["citation (0).csv"];
foreach($f as $v){

    $ct = file_get_contents($v);
    //$v = str_replace("\r","",$ct);
    $data = explode("AQAAQAAQA",$ct);
    //print_r($data);
    //die(sizeof($data)."X");
    foreach($data as $line){
        $line = trim($line);
        $cells = explode("\t",$line);
        if(sizeof($cells)<5){
            continue;
        }
        //print_r($cells);
        if($cells[0] == "ORN"){
            $headers = $cells;
            //print_r($headers);
            //exit;
        }else{
            $xxx = 0;
            foreach($cells as $cell){
                $cell = str_replace(["\n"],["\r"],$cell);
                $cell = str_replace(["\r\r"],["\r"],$cell);
                $cell = str_replace(["\r"],[";"],$cell);
                $store[$headers[$xxx++]] = $cell;
            }
        }
        $perm_records[] = $store;
    }
    
}
//print_r($perm_records);
//file_put_contents("store.json",json_encode($perm_records)    );

$csv = '';
foreach($perm_records as $row) {
    if(sizeof($row)>5){
        foreach(array_keys($row) as $v){
            if(trim($v)!=""){
                $kkk[] = $v;
            }
        }        
    }
}
$kkk = array_unique($kkk);
print_r($kkk);
$txt = implode("\t",$kkk);;
foreach($perm_records as $row) {
    if(sizeof($row)>5){
        //print_r($row);
        //exit;
        foreach($kkk as $v){
            $txt .= $row[$v]."\t";
        }
        $txt.="\n";
    }
}
file_put_contents("csv2.csv",$txt);