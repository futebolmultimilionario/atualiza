<?php
$update = file_get_contents("php://input");
$updateArray = json_decode($update, TRUE);
if(isset($updateArray["message"]["text"])){
$texto = $updateArray["message"]["text"];

$arrayTexto = preg_split("/\r\n|\n|\r/", $texto);
/*
$arrayTexto[2] = substr($arrayTexto[2], 8);
$arrayTexto[3] = preg_split("/\s+/", $arrayTexto[3]);

$time1 = preg_split("/\b @ \b/iu", $arrayTexto[5]);
$time2 = preg_split("/\b @ \b/iu", $arrayTexto[7]);

$empate = preg_split("/\b @ \b/iu", $arrayTexto[6]);

$arrayTexto[3] = strtotime(DateTime::createFromFormat("d/m/Y H:i", $arrayTexto[3][1]."/2021 ".$arrayTexto[3][2])->format('m/d/Y H:i:s')); // define data desejada

$db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");

if($arrayTexto[0] == "Abertura"){
	$query = "INSERT INTO tabelateste (campeonato, data, time1, oddtime1, oddempate, time2, oddtime2, link) VALUES ('$arrayTexto[2]', '$arrayTexto[3]', '$time1[0]', '$time1[1]', '$empate[1]', '$time2[0]', '$time2[1]', '$arrayTexto[9]')";
	$result = pg_query($db_handle, $query);

}
if($arrayTexto[0] == "Reabertura"){
	$query = "UPDATE tabelateste SET campeonato='$arrayTexto[2]', data='$arrayTexto[3]', oddtime1='$time1[1]', oddempate='$empate[1]', time2='$time2[0]', oddtime2='$time2[1]', link='$arrayTexto[9]' WHERE time1='$time1[0]' and time2='$time2[0]'";
	$result = pg_query($db_handle, $query);

 
}

pg_close($db_handle);*/
ob_start();
var_dump($arrayTexto);
$input = ob_get_contents();
ob_end_clean();
file_put_contents('input_requests.log',$input.PHP_EOL,FILE_APPEND);
}else{
	echo "Ok!";
}
?>
