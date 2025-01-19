<?php
require 'setting/system.php';

//api data from esp8266
require 'save_data.php';

$sql = "SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1";
$result = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

$data = array();
// If there is data, return the latest sensor readings
if ($result > 0) {
    $data['temperature'] = $result['temperature'];
    $data['humidity'] = $result['humidity'];
    $data['timestamp'] = $result['timestamp'];  // The timestamp of the data
} else {
    $data['temperature'] = "No data";
    $data['humidity'] = "No data";
    $data['timestamp'] = "No data";
}

// Return data as JSON
echo json_encode($data);

