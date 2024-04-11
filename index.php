<!DOCTYPE html>
<html>
<head>
    <!-- Load plotly.js into the DOM -->
    <script src='https://cdn.plot.ly/plotly-2.27.0.min.js'></script>
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = "http://api.nbp.pl/api/exchangerates/rates/a/gbp/last/10/?format=json";
$client = curl_init($url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

// Check if curl_exec was successful
if ($response === false) {
    echo 'Curl error: ' . curl_error($client);
    exit; // Stop further execution
}

// Decode the JSON response
$result = json_decode($response);

// Check if JSON decoding was successful
if ($result === null) {
    echo 'JSON decoding error: ' . json_last_error_msg();
    exit; // Stop further execution
}

// Close the cURL session
curl_close($client);
?>

<div id="myDiv"><!-- Plotly chart will be drawn inside this DIV --></div>

<script>
    var trace2 = {
        x: [<?php
            foreach ($result->rates as $rate) {
                echo $rate->mid . ',';
            }
            ?>],
        y: [<?php
            for ($i = 1; $i <= 10; $i++) {
                echo $i . ',';
            }
            ?>],
        mode: 'lines+markers',
        name: 'spline',
        line: {shape: 'spline'},
        type: 'scatter'
    };

    var data = [trace2];

    Plotly.newPlot('myDiv', data);
</script>

</body>
</html>
