<?php

// phpinfo();

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


$json = getData('https://api.kawalcorona.com/indonesia/provinsi/');

$array = json_decode($json);

$positif = json_decode(getData('http://covid19.datapedia.id/json/map_prop_positif.php'));
$sembuh = json_decode(getData('http://covid19.datapedia.id/json/map_prop_sembuh.php'));
$rawat = json_decode(getData('http://covid19.datapedia.id/json/map_prop_rawat.php'));
$meninggal = json_decode(getData('http://covid19.datapedia.id/json/map_prop_meninggal.php'));



function getColor($value){
    if($value > 10 && $value < 20){
        $color = "#FED976";
    }elseif($value > 20 && $value < 50){
        $color = "#FEB24C";
    }elseif($value > 50 && $value < 100){
        $color = "#FD8D3C";
    }elseif($value > 100 && $value < 200){
        $color = "#FC4E2A";
    }elseif($value > 200 && $value < 500){
        $color = "#E31A1C";
    }elseif($value > 500 && $value < 1000){
        $color = "#BD0026";
    }elseif($value > 1000){
        $color = "#800026";
    }else{
        $color = "#FFEDA0";
    }
    return $color;
}

function json_change_key($arr, $oldkey, $newkey) {
    $json = str_replace('"'.$oldkey.'":', '"'.$newkey.'":', json_encode($arr));
    return json_decode($json); 
}

$positif = json_change_key($positif,'value','positif');

$sembuh = json_change_key($sembuh,'value','sembuh');
$rawat = json_change_key($rawat,'value','rawat');
$meninggal = json_change_key($meninggal,'value','meninggal');

$no = 0;
foreach($positif as $key => $val){
    // $ratio = bcdiv($val->positif / $max,1);
    $data[] = array('id' => $val->id,'positif'=> $val->positif,'sembuh' => $sembuh[$no]->sembuh,'rawat' => $rawat[$no]->rawat,'meninggal' => $meninggal[$no]->meninggal,'fill' => getColor($val->positif));
    $no++;
}

echo(json_encode($data));



?>