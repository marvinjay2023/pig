<?php

include 'theme/head.php';
include 'theme/sidebar.php';
include 'session.php';

// Function to fetch data from the thermal camera (e.g., an API or local endpoint)
function getThermalData() {
    // Replace with the actual logic to get data from the thermal camera
    $apiUrl = 'http://192.168.43.19/ti-stream'; // Replace with your thermal camera API URL
    $response = file_get_contents($apiUrl);

    // Check for errors in the HTTP request
    if ($response === false) {
        die('Error fetching data from the thermal camera.');
    }

    // Decode the JSON response (assuming the camera sends JSON data)
    $data = json_decode($response, true);

    // Validate the structure of the received data
    if (isset($data['temperature'])) {
        return [
            'temperature' => $data['temperature']
        ];
    } else {
        die('Invalid data structure received from thermal camera.');
    }
}

// Check if data is being collected and posted
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Get data from the thermal camera
//     $thermalData = getThermalData();
//     $temperature = $thermalData['temperature'];

//     // Prepare and execute the database query to insert only temperature data
//     $query = "INSERT INTO thermal_data (temperature) VALUES (?)";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("d", $temperature); // 'd' for double

//     if ($stmt->execute()) {
//         echo "<div class='alert alert-success'>Data inserted successfully!</div>";
//     } else {
//         echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
//     }
//     $stmt->close();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermal Sensor</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fullscreen container to center the content */
        .fullscreen-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa; /* Light gray background */
        }

        /* Outer box styling */
        #zoomDiv {
            width: 600px;
            height: 600px;
            border: 2px solid #0056b3; /* Blue border */
            border-radius: 10px; /* Rounded corners */
            background-color: #ffffff; /* White background */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            overflow: hidden; /* Prevent overflow of iframe */
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px; /* Add space between the box and the buttons */
        }

        /* Inner square for the iframe */
        #innerSquare {
            width: 400px; /* Inner square size */
            height: 400px;
            overflow: hidden; /* Hide anything outside the inner square */
            position: relative;
            transition: transform 0.3s ease; /* Smooth zoom transition */
        }

        /* Iframe styling */
        #innerSquare iframe {
            width: 500%;
            height: 500%;
            border: none;
        }

        /* Button styling */
        .zoom-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <!-- Header -->
        <header class="w3-container" style="padding-top:22px"></header>

        <div class="fullscreen-container">
            <div id="zoomDiv">
                <!-- Inner square containing the iframe -->
                <div id="innerSquare">
                    <!-- Iframe loading the webpage -->
                    <!-- <iframe src="http://192.168.1.100/ti-stream"></iframe> -->
                    <img src="http://192.168.1.101/ti-stream" alt="thermal image" style="width: 100%; height: 100%;">
                </div>
            </div>

            <!-- Zoom buttons -->
            <div class="zoom-buttons">
                <button class="btn btn-primary" onclick="zoomIn()">Zoom In</button>
                <button class="btn btn-secondary" onclick="zoomOut()">Zoom Out</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) and custom JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let scale = 1; // Initial scale of the inner square

        function zoomIn() {
            scale += 0.1; // Increase scale by 0.1 with each zoom in
            document.querySelector("#innerSquare").style.transform = `scale(${scale})`;
        }

        function zoomOut() {
            if (scale > 0.5) {
                scale -= 0.1; // Decrease scale by 0.1 with each zoom out
                document.querySelector("#innerSquare").style.transform = `scale(${scale})`;
            }
        }
    </script>
</body>
</html>

<?php include 'theme/foot.php'; ?>
