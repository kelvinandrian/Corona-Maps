<?php

$json = file_get_contents('https://api.kawalcorona.com/indonesia/provinsi/');

$array = json_decode($json);

$positif = json_decode(file_get_contents('http://covid19.datapedia.id/json/map_prop_positif.php'));
$sembuh = json_decode(file_get_contents('http://covid19.datapedia.id/json/map_prop_sembuh.php'));
$rawat = json_decode(file_get_contents('http://covid19.datapedia.id/json/map_prop_rawat.php'));
$meninggal = json_decode(file_get_contents('http://covid19.datapedia.id/json/map_prop_meninggal.php'));



function getColor($d) {
    return $d > 1000 ? '#800026' :
           $d > 500  ? '#BD0026' :
           $d > 200  ? '#E31A1C' :
           $d > 100  ? '#FC4E2A' :
           $d > 50   ? '#FD8D3C' :
           $d > 20   ? '#FEB24C' :
           $d > 10   ? '#FED976' :
                      '#FFEDA0';
}

function linear_color($from, $to, $ratio) {
    // normalize ralio
    $ratio = $ratio<0?0:($ratio>1?1:$ratio);
    // unsure colors are numeric values
    if(!is_numeric($from))$from=hexdec($from);
    if(!is_numeric($to))$to=hexdec($to);

    $rf = 0xFF & ($from >> 0x10);
    $gf = 0xFF & ($from >> 0x8);
    $bf = 0xFF & $from;
    $rt = 0xFF & ($to >> 0x10);
    $gt = 0xFF & ($to >> 0x8);
    $bt = 0xFF & $to;
    return str_pad( dechex(($bf + (($bt-$bf)*$ratio)) + ($gf + (($gt-$gf)*$ratio) << 0x8) + ($rf + (($rt-$rf)*$ratio) << 0x10)), 6,'0',STR_PAD_LEFT);
}

function json_change_key($arr, $oldkey, $newkey) {
    $json = str_replace('"'.$oldkey.'":', '"'.$newkey.'":', json_encode($arr));
    return json_decode($json); 
}

$positif = json_change_key($positif,'value','positif');

$numbers = array_column($array, 'positif');
$min = min($numbers);
$max = max($numbers);

$sembuh = json_change_key($sembuh,'value','sembuh');
$rawat = json_change_key($rawat,'value','rawat');
$meninggal = json_change_key($meninggal,'value','meninggal');

$no = 0;
foreach($positif as $key => $val){
    $ratio = bcdiv($val->positif / $max,1);
    $data[] = array('id' => $val->id,'positif'=> $val->positif,'sembuh' => $sembuh[$no]->sembuh,'rawat' => $rawat[$no]->rawat,'meninggal' => $meninggal[$no]->meninggal,'fill' => getColor($val->positif));
    $no++;
}

echo(json_encode($data));



?>