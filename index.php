<?php
$update = file_get_contents("php://input");
$updateArray = json_decode($update, TRUE);
ob_start();
var_dump($updateArray);
$input = ob_get_contents();
ob_end_clean();
file_put_contents('input_requests.log',$input.PHP_EOL,FILE_APPEND);
if(isset($updateArray["channel_post"]["text"]) && strpos($updateArray["channel_post"]["text"], "www.bet365.com") !== false){
$texto = $updateArray["channel_post"]["text"];

$arrayTexto = preg_split("/\r\n|\n|\r/", $texto);

	
	
$arrayTexto[0] = substr($arrayTexto[0], 8);
$arrayTexto[2] = preg_split("/\s+/", $arrayTexto[2]);

$time1 = preg_split("/\b @ \b/iu", $arrayTexto[4]);
$time2 = preg_split("/\b @ \b/iu", $arrayTexto[6]);

$empate = preg_split("/\b @ \b/iu", $arrayTexto[5]);
if(array_key_exists(2, $arrayTexto[2])){
$arrayTexto[2] = strtotime(DateTime::createFromFormat("d/m/Y H:i", $arrayTexto[2][1]."/2021 ".$arrayTexto[2][2])->format('m/d/Y H:i:s'))+10800; // define data desejada

$db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
$selecionar = "SELECT * FROM tabelateste WHERE time1='$time1[0]' and time2='$time2[0]'";
$buscar = pg_query($db_handle, $selecionar);
$arrayBuscar = pg_fetch_assoc($buscar);

if(isset($arrayBuscar["time1"])){
	$agora = time();
	$query = "UPDATE tabelateste SET campeonato='$arrayTexto[0]', hora='$agora', data='$arrayTexto[2]', oddtime1='$time1[1]', oddempate='$empate[1]', time2='$time2[0]', oddtime2='$time2[1]', link='$arrayTexto[8]' WHERE time1='$time1[0]' and time2='$time2[0]'";
	$result = pg_query($db_handle, $query);
	$deletaantigos = pg_query($db_handle, "DELETE FROM tabelateste WHERE data < '$agora'");
}else{
	$agora = time();
	$query = "INSERT INTO tabelateste (campeonato, hora, data, time1, oddtime1, oddempate, time2, oddtime2, link) VALUES ('$arrayTexto[0]', '$agora', '$arrayTexto[2]', '$time1[0]', '$time1[1]', '$empate[1]', '$time2[0]', '$time2[1]', '$arrayTexto[8]')";
	$result = pg_query($db_handle, $query);
	$deletaantigos = pg_query($db_handle, "DELETE FROM tabelateste WHERE data < '$agora'"); 
}

pg_close($db_handle);
}
}else{
	echo "Ok!";
}

?>
