<?php 



function readSensor($sensor) 
{ 

	$output = array(); 
	$return_var = 0; 
	$i=1; 
	exec('sudo /usr/local/bin/lol_dht22/loldht '.$sensor, $output, $return_var); 
  	while (substr($output[$i],0,1)!="H") 
	{ 
                $i++; 
	} 
	$humid=substr($output[$i],11,5); 
        $temp=substr($output[$i],33,5); 	

	echo "temp: $temp\n";
	echo "humid: $humid\n";


	$arr = (object) [
	'temperature' => $temp,
	'humidity' => $humid 
	];


	$json = json_encode($arr);

	echo $json;

	$url='http://xy.azurewebsites.net/values';
	$data = $arr;
	
	$options = array(
		'http' => array(
	        'header'  => "Content-type: application/json",
	        'method'  => 'POST',
        	'content' => json_encode($data)
	    )
	);

	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }
	
	var_dump($result);
	
	//sleep(10);

	//readSensor(7);


	return; 
} 
readSensor(7); 
?> 

