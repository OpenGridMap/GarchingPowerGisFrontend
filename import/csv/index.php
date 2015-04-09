<?php
header("Content-Type: text/html; charset=utf-8");
include('../config.inc.php');

if (($handle = fopen("data.csv", "r")) !== FALSE) {
    $dbconn = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS)
    or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }

        $query = "INSERT INTO planet_osm_point (osm_id,power,\"addr:postcode\",\"addr:city\",way, ref) VALUES (" . $data[0] . ", 'transformer', '" . $data[1] . "', '" . $data[2] . "', ST_Geometry('SRID=900913;POINT(" . $data[3] . " " . $data[4] . ")'), '" . $data[5] . "');";
        $result = pg_query($dbconn, $query);
        echo  "Query: " . $query;
        if (pg_affected_rows($result) == 0) {
            echo "Fehler beim Eintrag<br /><br />";
        } else {
            echo "Erfolgreich eingetragen<br /><br />";}
    }
    fclose($handle);
}