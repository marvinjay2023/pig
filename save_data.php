<?php
    
	$url = 'http://pigfarm.atwebpages.com/data.json';

	// Get JSON data
	$json_data = file_get_contents($url);

	// Check if data was fetched successfully
	if (!$json_data) {
		// Decode the JSON data into an array
		echo "Failed to retrieve data.";
		die;
	} 

	$data = json_decode($json_data, true);  // 'true' returns as an associative array

    //----------------------------------------------------------------------------

	$save_sql = "INSERT INTO sensor_data(temperature,humidity,timestamp) 
			VALUES('".$data['temperature']."','".$data['humidity']."','".date("Y-m-d H:i:s")."')";

	if($db->query($save_sql) === FALSE)
		{ echo "Error: " . $save_sql . "<br>" . $db->error; }

