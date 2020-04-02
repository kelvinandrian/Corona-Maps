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
        $color = "#EABAB5";
    }elseif($value > 20 && $value < 50){
        $color = "#E3A097";
    }elseif($value > 50 && $value < 100){
        $color = "#DC8779";
    }elseif($value > 100 && $value < 200){
        $color = "#D46D5A";
    }elseif($value > 200 && $value < 500){
        $color = "#CD543C";
    }elseif($value > 500 && $value < 1000){
        $color = "#C63A1E";
    }elseif($value > 1000){
        $color = "#BF2100";
    }else{
        $color = "#F2D4D4";
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