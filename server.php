#!/usr/bin/php
<?php 
while (true) {
	$url="http://localhost:55555/poll.xml";
	$cloudurl="http://sensey.ee/gui/api/value/";	
	//$url="poll.xml";
	//$cloudurl="http://localhost/garage48/gui/api/value/";
	$xml = simplexml_load_file($url);
	$nodes=$xml->xpath("/poll/node/value");
	//print_r($xml);
	if (isset($nodes)){
		foreach ($nodes as $node) {
			echo 'node'.PHP_EOL;
			$label=(string)$node['label'];
			$instance=(string)$node['instance'];
			$sensorName=urlencode($label.$instance);
			echo $instance.PHP_EOL;
			if(($node['class']=='SENSOR MULTILEVEL') OR ($node['class']=='METER' && $label=='Energy')){
				$r_url=$cloudurl."?sensor=".$sensorName."&value=".urlencode($node);
				echo $r_url.PHP_EOL;
				$ch = curl_init($r_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_exec($ch);
				curl_close($ch);
			}
		}
	}
	sleep(2);
}
?>
