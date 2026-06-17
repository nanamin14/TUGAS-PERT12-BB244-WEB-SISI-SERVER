<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$url = "https://herdian.stikom-bali.ac.id/api/sensor/index.php";

$client = new Client();
$response = $client->get($url);
$data = json_decode($response->getBody(), true);
?>

<table border="1">
    <tr>
        <th>Sensor</th>
        <th>Nilai</th>
        <th>Waktu</th>
    </tr>
    <?php foreach ($data as $d) { ?>
    <tr>
        <td><?php echo $d['sensor']; ?></td>
        <td><?php echo $d['nilai']; ?></td>
        <td><?php echo $d['waktu']; ?></td>
    </tr>
    <?php } ?>
</table>

