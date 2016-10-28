<?php
include('import/config.inc.php');

$dbconn = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS)
or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

$query = "SELECT ST_AsGeoJSON(ST_Transform(way, 4326)) as way FROM dijkstra_powerlines WHERE osm_id = 999999999990005 AND way IS NOT NULL;";

$result = pg_query($dbconn, $query);
$i = 1;
$rows = pg_num_rows($result);
if ($rows > 0) {
    echo '{ "type": "FeatureCollection",' . "\n" . '   "features": [' . "\n";
    while ($data = pg_fetch_object($result)) {
        echo '{ "type": "Feature",' . "\n" . '        "geometry": ';
        echo $data->way;
        echo '}';
        if ($i != $rows) {
            echo ',';
        }
        echo "\n";
        //echo '},' . "\n";
        $i++;
    }
    echo "\n" . ']' . "\n" . '     }';
}