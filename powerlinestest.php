<?php
include('import/config.inc.php');

$dbconn = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS)
or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

// find the transformed coordinates of the house
$query = "Select ST_Transform(ST_Centroid(way), 4326) as way from planet_osm_polygon where not building = '' and osm_id = 171867723";
$result = pg_query($dbconn, $query);
$house = '';
if (pg_num_rows($result) == 1) {
    $house = pg_fetch_object($result);
} else {
    echo "Error";
    exit;
}

// find the transformed coordinates of th transformer
$query = "SELECT ST_Transform(way, 4326) as way FROM planet_osm_point where osm_id = 999999999990005;";
$result = pg_query($dbconn, $query);
$transformer = '';
if (pg_num_rows($result) == 1) {
    $transformer = pg_fetch_object($result);
} else {
    echo "Error";
    exit;
}
pg_close($dbconn);
$dbconn = pg_connect('host=' . DB_HOST . ' dbname= pgrouting user=' . DB_USER . ' password=' . DB_PASS)
or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

$query = "SELECT ST_AsGeoJSON( (SELECT ST_MakeLine(route.geom) FROM ( SELECT geom"
        ." FROM pgr_fromAtoB('ways', ST_X('" . $house->way . "'),ST_Y('" . $house->way
        . "'),ST_X('" . $transformer->way . "'),ST_Y('" . $transformer->way . "') ) ORDER BY seq) AS route)) as way;";

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