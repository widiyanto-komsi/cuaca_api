<?php
	$url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22Yogyakarta%22)%20and%20u%3D%22c%22&format=xml&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
	$sUrl = file_get_contents($url, False);
	
	$xml = simplexml_load_string($sUrl);
	
	//print_r($xml);
	echo $xml->results->channel->title."<br><br>";
	
	$namespace=$xml->results->channel->item->getNamespaces(true);
	$date = $xml->results->channel->item->children($namespace['yweather']);
	//print_r($date);
	
	$now = $date->condition->attributes();
	echo "Cuaca ".$now['date']." adalah ".$now['text']." dengan suhu ".$now['temp']."&#8451<br><br>";
	
	echo"<table border='1'>
		<thead>
			<th>Tanggal</th>
			<th>Suhu Maksimal</th>
			<th>Suhu Minumal</th>
			<th>Cuaca</th>
		</thead>";

	for($i=0; $i<10; $i++) {
		$cuaca = $date->forecast[$i]->attributes();
		echo "<tr align='center'><td>".$cuaca['day'].", ";
		echo $cuaca['date']."</td>";
		echo "<td>".$cuaca['high']."</td>";
		echo "<td>".$cuaca['low']."</td>";
		echo "<td>".$cuaca['text']."</td></tr>";
	}
	echo"</table>";