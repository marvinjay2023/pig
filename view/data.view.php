<?php 
if (!isset($_SESSION['id'])) {
    header('Location: /login'); 
    exit();
}

include 'theme/head.php';
include 'theme/sidebar.php';
//include 'session.php';
?>
<style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        .home-button {
            position: absolute;
            left: 10;
            top: 0;
            z-index: 20;
        }
</style>
<div class="w3-main" style="margin-left:300px;margin-top:50px;">
    <div class="container w3-white" style="padding: 32px 32px;">
        <h1 class="text-center mb-4">Real-Time Temperature and Humidity Data</h1>

        <!-- Real-Time Data Display -->
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3 text-center">
                <h3>Current Data</h3>
                <p>Temperature: <span id="temperature">Loading...</span> °C</p>
                <p>Humidity: <span id="humidity">Loading...</span> %</p>
                <p>Time Stamp: <span id="timestamp">Loading...</span></p>
            </div>
        </div>

        <!-- Line Chart for Temperature and Humidity -->
        <div class="row">
            <div class="col-12 chart-container">
                <canvas id="sensorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-8eZtQF9SoXn3IoD8V4zV92g6ygaytYlfQFshx88yAYq6z2aZZ4vPOMjXY8HYfbr6" crossorigin="anonymous"></script>
    
    <script>
        // Initialize arrays to store the real-time data
        let temperatureData = [];
        let humidityData = [];
        let timeLabels = [];

        // Set up Chart.js
        const ctx = document.getElementById('sensorChart').getContext('2d');
        const sensorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: timeLabels, // Labels will represent time
                datasets: [
                    {
                        label: 'Temperature (°C)',
                        data: temperatureData, // Temperature data
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Humidity (%)',
                        data: humidityData, // Humidity data
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10
                        }
                    },
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // Function to fetch the latest data from the PHP script
        function fetchData() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch.php', true);  // Update with the correct PHP file path
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);

                    // Update the real-time data displayed on the page
                    document.getElementById('temperature').innerText = data.temperature;
                    document.getElementById('humidity').innerText = data.humidity;
                    document.getElementById('timestamp').innerText = data.timestamp;

                    // Push new data to the arrays
                    const currentTime = Date.now();  // Current timestamp

                    timeLabels.push(currentTime);
                    temperatureData.push(data.temperature);
                    humidityData.push(data.humidity);

                    // Keep the graph to show only the last 10 data points
                    if (timeLabels.length > 10) {
                        timeLabels.shift();
                        temperatureData.shift();
                        humidityData.shift();
                    }

                    // Update the chart with new data
                    sensorChart.update();
                }
            };
            xhr.send();
        }

        // Fetch the data every 5 seconds to update the UI
        setInterval(fetchData, 2000);
        
        // Initial fetch when the page loads
        fetchData();
    </script>
</body>
</html>
