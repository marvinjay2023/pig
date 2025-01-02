<?php
    require 'config.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }else{
        echo "connected";
    }

    // Insert new data from Arduino
    if (isset($_GET['temperature']) && isset($_GET['humidity'])) {
        $temperature = $_GET['temperature'];  // Receive temperature from Arduino
        $humidity = $_GET['humidity'];        // Receive humidity from Arduino

        // Prepare SQL query to insert data
        $sql = "INSERT INTO sensor_data (temperature, humidity) VALUES ('$temperature', '$humidity')";

        // Execute query
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fetch the most recent data
    $sql = "SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1";  // Assuming 'id' is the primary key
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the data
        $row = $result->fetch_assoc();
        $temperature = $row['temperature'];
        $humidity = $row['humidity'];
        $timestamp = $row['timestamp'];

        echo json_encode(array('temperature' => $temperature, 'humidity' => $humidity, 'timestamp' => $timestamp));
    } else {
        echo json_encode(array('temperature' => 'No data', 'humidity' => 'No data', 'timestamp' => 'No data'));
    }

    $conn->close();
?>
