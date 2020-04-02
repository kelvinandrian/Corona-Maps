<?php

$url = 'http://covid19.datapedia.id/json/';

function getData($url){
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    return $output;
}

$positif = json_change_key(json_decode(getData($url.'trend_positif.php')),'frequensi','positif');
$sembuh = json_change_key(json_decode(getData($url.'trend_sembuh.php')),'frequensi','sembuh');
$rawat = json_change_key(json_decode(getData($url.'trend_rawat.php')),'frequensi','rawat');
$meninggal = json_change_key(json_decode(getData($url.'trend_meninggal.php')),'frequensi','meninggal');

function json_change_key($arr, $oldkey, $newkey) {
    $json = str_replace('"'.$oldkey.'":', '"'.$newkey.'":', json_encode($arr));
    return json_decode($json); 
}

$no = 0;
foreach($positif as $key => $val){
    // $ratio = bcdiv($val->positif / $max,1);
    $data[] = array('tgl' => $val->tgl,'positif'=> $val->positif,'sembuh' => $sembuh[$no]->sembuh,'rawat' => $rawat[$no]->rawat,'meninggal' => $meninggal[$no]->meninggal);
    $no++;
}

function sortir($data,$sort){

    foreach($data as $key => $val){
        $result[] = $val[$sort];
    }
    return json_encode($result);
}

if(isset($_GET['tipe'])){
    if($_GET['tipe'] == 'tanggal'){
        echo sortir($data,'tgl');
    }elseif($_GET['tipe'] == 'positif'){
        echo sortir($data,'positif');
    }elseif($_GET['tipe'] == 'sembuh'){
        echo sortir($data,'sembuh');
    }elseif($_GET['tipe'] == 'meninggal'){
        echo sortir($data,'meninggal');
    }elseif($_GET['tipe'] == 'rawat'){
        echo sortir($data,'rawat');
    }else{
        echo json_encode($data);
    }
}