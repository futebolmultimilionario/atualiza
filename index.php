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

		if(array_key_exists(2, $arrayTexto[2])){
			$arrayTexto[2] = strtotime(DateTime::createFromFormat("d/m/Y H:i", $arrayTexto[2][1]."/2021 ".$arrayTexto[2][2])->format('m/d/Y H:i:s'))+10800; // define data desejada

			if(strpos($texto, "+") === false && strpos($texto, "DNB") === false){
				$time1 = preg_split("/\b @ \b/iu", $arrayTexto[4]);
				$time2 = preg_split("/\b @ \b/iu", $arrayTexto[6]);

				$empate = preg_split("/\b @ \b/iu", $arrayTexto[5]);

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
			}else{
				$time1 = substr($arrayTexto[1], 0, strpos($arrayTexto[1], "x")-1);
				$time2 = substr($arrayTexto[1], strpos($arrayTexto[1], "x")+2);
			
				if(strpos($texto, "+") !== false){

					$linhatime1 = substr($arrayTexto[4], strlen($time1)+1, strpos($arrayTexto[4], "@")-2-strlen($time1));
					$linhatime2 = substr($arrayTexto[5], strlen($time2)+1, strpos($arrayTexto[5], "@")-2-strlen($time2));

					$oddasiaticatime1 = preg_split("/\b @ \b/iu", $arrayTexto[4])[1];
					$oddasiaticatime2 = preg_split("/\b @ \b/iu", $arrayTexto[5])[1];

					$db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
					$selecionar = "SELECT * FROM tabelateste WHERE time1='$time1' and time2='$time2'";
					$buscar = pg_query($db_handle, $selecionar);
					$arrayBuscar = pg_fetch_assoc($buscar);

					if(isset($arrayBuscar["time1"])){
						$agora = time();
						$query = "UPDATE tabelateste SET campeonato='$arrayTexto[0]', hora='$agora', data='$arrayTexto[2]', oddasiatica1='$oddasiaticatime1', oddasiatica2='$oddasiaticatime2', link='$arrayTexto[7]' WHERE time1='$time1' and time2='$time2'";
						$result = pg_query($db_handle, $query);
						$deletaantigos = pg_query($db_handle, "DELETE FROM tabelateste WHERE data < '$agora'");
					
					}else{
						$agora = time();
						$query = "INSERT INTO tabelateste (campeonato, hora, data, time1, oddasiatica1, time2, oddasiatica2, link) VALUES ('$arrayTexto[0]', '$agora', '$arrayTexto[2]', '$time1', '$oddasiaticatime1', '$time2', '$oddasiaticatime2', '$arrayTexto[7]')";
						$result = pg_query($db_handle, $query);
						$deletaantigos = pg_query($db_handle, "DELETE FROM tabelateste WHERE data < '$agora'"); 
					}
				} else if (strpos($texto, "DNB") !== false){
					$odddnbtime1 = substr($arrayTexto[4], strpos($arrayTexto[4], ":")+2);
					$odddnbtime2 = substr($arrayTexto[5], strpos($arrayTexto[5], ":")+2);

					$odddctime1 = substr($arrayTexto[7], strpos($arrayTexto[7], ":")+2);
					$odddctime2 = substr($arrayTexto[8], strpos($arrayTexto[8], ":")+2);

					$db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
					$selecionar = "SELECT * FROM tabelateste WHERE time1='$time1' and time2='$time2'";
					$buscar = pg_query($db_handle, $selecionar);
					$arrayBuscar = pg_fetch_assoc($buscar);

					if(isset($arrayBuscar["time1"])){
						$agora = time();
						$query = "UPDATE tabelateste SET campeonato='$arrayTexto[0]', hora='$agora', data='$arrayTexto[2]', odddnbtime1='$odddnbtime1', odddnbtime2='$odddnbtime2', link='$arrayTexto[10]', odddctime1='$odddctime1', odddctime2='$odddctime2' WHERE time1='$time1' and time2='$time2'";
						$result = pg_query($db_handle, $query);
						$deletaantigos = pg_query($db_handle, "DELETE FROM tabelateste WHERE data < '$agora'");
					
					}else{
						$agora = time();
						$query = "INSERT INTO tabelateste (campeonato, hora, data, time1, odddnbtime1, time2, odddnbtime2, link, odddctime1, odddctime2) VALUES ('$arrayTexto[0]', '$agora', '$arrayTexto[2]', '$time1', '$odddnbtime1', '$time2', '$odddnbtime2', '$arrayTexto[10]', '$odddctime1', '$odddctime2')";
						$result = pg_query($db_handle, $query);
						$deletaantigos = pg_query($db_handle, "DELETE FROM tabelateste WHERE data < '$agora'"); 
					}

				}
			
			}
		
		}
}else{
	echo "Ok!";
	}

?>
