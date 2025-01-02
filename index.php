<?php 

const BASE_PATH = __DIR__;

require 'setting/system.php';
require 'Router.php';

// URL of the MJPEG stream
// $url = "http://192.168.1.101/ti-stream";

// // Initialize cURL
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); // Stream output directly
// curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {

//     // Look for JPEG frame markers
//     static $frame = '';
//     $frame .= $data;

//     // JPEG frame starts with FF D8 and ends with FF D9
//     $start = strpos($frame, "\xFF\xD8");
//     $end = strpos($frame, "\xFF\xD9");

//     if ($start !== false && $end !== false && $end > $start) {
//         $jpeg = substr($frame, $start, $end - $start + 2);
//         $frame = substr($frame, $end + 2); // Keep remaining data
//         // Save the frame to a file or process it
//         $filename = "frame_" . time() . ".jpg";
//         file_put_contents($filename, $jpeg);
//         echo "Frame saved: $filename\n";
//         // Stop after one frame for demonstration purposes
//         exit;
//     }

//     return strlen($data); // Required for cURL
// });

// // Execute the cURL request
// curl_exec($ch);

// //Check for errors
// if (curl_errno($ch)) {
//     echo "Error: " . curl_error($ch);
// }

// curl_close($ch);






// // Set headers for MJPEG streaming
// header("Content-Type: multipart/x-mixed-replace; boundary=--myboundary");

// // Open the MJPEG stream
// $stream = fopen("http://192.168.1.101/ti-stream", "r");

// if ($stream) {
//     while (!feof($stream)) {
//         // Read data from the MJPEG stream
//         $data = fread($stream, 8192);
//         echo $data; // Output data directly to the client
//         ob_flush();
//         flush();
//     }
//     fclose($stream);
// } else {
//     echo "Unable to connect to the MJPEG stream.";
// }

// Function to get a frame from the MJPEG stream
// function get_mjpeg_frame($url) {
//     // Open the MJPEG stream using cURL
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout for the stream
//     $data = curl_exec($ch);
//     curl_close($ch);
//     return $data;
// }

// // Function to extract temperature from thermal image (example: grayscale value or color mapping)
// function extract_temperature_from_image($image) {
//     // Load the image using GD or Imagick
//     $image = base64_decode($image);
//     $img = imagecreatefromstring($image); // GD example

//     if ($img === false) {
//         die('Error loading image.');
//     }

//     // Process image pixel by pixel (example: simple grayscale extraction)
//     $width = imagesx($img);
//     $height = imagesy($img);
    
//     // Here we would process the pixels, but for simplicity, we're just reading the color of the first pixel
//     $rgb = imagecolorat($img, 0, 0);
//     $r = ($rgb >> 16) & 0xFF;  // Red component
//     $g = ($rgb >> 8) & 0xFF;   // Green component
//     $b = $rgb & 0xFF;          // Blue component
    
//     // Temperature extraction logic (example, needs to be specific to your thermal camera's encoding)
//     // For example, if the color is in the red channel, map it to a temperature range.
//     $temperature = $r * 0.1; // Just a simple example, use real mapping here
//     return $temperature;
// }

// // Function to extract a timestamp (if available as EXIF data or from image)
// function extract_date_from_image($image) {
//     // If the image has EXIF data (JPEG typically), you can read it
//     $exif = exif_read_data($image);
//     if ($exif && isset($exif['DateTime'])) {
//         return $exif['DateTime'];  // Return date from EXIF
//     }
    
//     // If no EXIF data, check if the timestamp is embedded as text (for example, OCR)
//     // This would require an OCR library to extract text from the image (e.g., Tesseract)
    
//     return null;  // No date found
// }

// // URL to the MJPEG stream
// $mjpeg_url = 'http://192.168.1.101/ti-stream';

// // Retrieve a frame from the MJPEG stream
// $frame = get_mjpeg_frame($mjpeg_url);

// // Extract temperature from the frame (assuming it's a thermal image)
// $temperature = extract_temperature_from_image($frame);
// var_dump($temperature);

// die;
// echo "Extracted temperature: " . $temperature . " °C\n";

// // Extract the date (from EXIF or other metadata)
// $date = extract_date_from_image($frame);
// echo "Extracted date: " . ($date ? $date : 'No date found') . "\n";


// header('Content-type: image/jpg');

// $img = file_get_contents('frame_1735755450.jpg');

// echo $img;
