import serial
import requests

# Set up serial connection (replace with the correct COM port or device path)
arduino = serial.Serial('COM6', 9600)  # Adjust COM port as necessary

# Set the server URL (change to your server's URL)
url = "http://localhost/pig/save_data.php"  # Replace with the actual URL of your PHP script

while True:
    if arduino.in_waiting > 0:
        data = arduino.readline().decode().strip()  # Read data from Arduino
        temp, hum = data.split(',')
        
        # Send data to the PHP server using a GET request
        payload = {'temperature': temp, 'humidity': hum}
        response = requests.get(url, params=payload)
        
        print(f"Sent data: Temp = {temp}, Hum = {hum}")
        print(f"Server Response: {response.text}")
yu