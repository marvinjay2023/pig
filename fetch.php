<?php
$servername = "localhost";  // Your MySQL server
$username = "root";     // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "pig";  // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the latest sensor data with timestamp
$sql = "SELECT temperature, humidity, timestamp FROM sensor_data ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$data = array();

// If there is data, return the latest sensor readings
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data['temperature'] = $row['temperature'];
        $data['humidity'] = $row['humidity'];
        $data['timestamp'] = $row['timestamp'];  // The timestamp of the data
    }
} else {
    $data['temperature'] = "No data";
    $data['humidity'] = "No data";
    $data['timestamp'] = "No data";
}

// Close connection
$conn->close();

// Return data as JSON
echo json_encode($data);
?>
