<?php
// OpenWeather API key
$apiKey = "2871765b2b4af6891f65d567781e1ab6";
$city = "Dhaka"; // City
$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

try {
    // Make a GET request to the OpenWeatherMap API
    $response = file_get_contents($url);
    if ($response === FALSE) {
        throw new Exception("Error fetching data from OpenWeatherMap API.");
    }

    // Decode the JSON response
    $weatherData = json_decode($response, true);

    // Extract the data you want to return
    $weather = [
        'temperature' => $weatherData['main']['temp'],
        'description' => $weatherData['weather'][0]['description'],
        'city' => $weatherData['name']
    ];

    // Set the header to application/json and return the weather data as JSON
    header('Content-Type: application/json');
    echo json_encode($weather);

} catch (Exception $e) {
    // Handle exceptions and return an error message as JSON
    echo json_encode(['error' => 'Error fetching weather data: ' . $e->getMessage()]);
}
?>
