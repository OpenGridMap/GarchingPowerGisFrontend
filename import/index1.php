<?php
$dbconn = pg_connect("host=localhost dbname=gis user=webuser password=msrg2014")
or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
echo "erfolgreich";

$query = 'select osm_id from planet_osm_point order by osm_id desc limit 1;';
$result = pg_query($dbconn, $query) or die('Fehler bei Abfrage der osm_id: ' . pg_last_error());
$data = pg_fetch_array($result, null, PGSQL_ASSOC);
$osm_id = $data['osm_id'] + 1;
echo $osm_id;

if (!empty($_POST['send'])) {
    $addrhousenumber = $_POST['addrhousenumber'];
    $generatorsource = $_POST['generatorsource'];
    $pointname = $_POST['pointname'];
    $operator = $_POST['operator'];
    $power = $_POST['power'];
    $power_source = $_POST['power_source'];
    $ref = $_POST['ref'];
    $lon = $_POST['lon'];
    $lat = $_POST['lat'];
    $cord_x = lon2x($lon);
    $cord_y = lon2x($lat);

    $query = "INSERT INTO planet_osm_point (osm_id,power,ref,way) VALUES ($osm_id, '$power', '$ref', ST_Geometry('SRID=900913;POINT($cord_x $cord_y)'));";
    $result = pg_query($dbconn, $query);
    echo  "Query: " . $query;
    if (pg_affected_rows($result) == 0) {
        echo "Ein Fehler ist aufgetreten.\n" . pg_last_error();
        exit;
    } else {
        echo "Daten erfolgreich eingetragen";
    }
}

function lon2x($lon) { return deg2rad($lon) * 6378137.0; }
function lat2y($lat) { return log(tan(M_PI_4 + deg2rad($lat) / 2.0)) * 6378137.0; }

?>

<html>
<head><title>Insert Power Tags in OpenStreetMap</title></head>
<body>
<h1>Insert new points in planet_osm_point:</h1>
<form name="input" method="post">
    <label for="osm_id">osm_id</label><input type="text" name="osm_id" value="<?php echo $osm_id; ?>"/>
    <label for="addrhousenumber">addr:housenumber</label><input type="text" name="addrhousenumber"/>
    <label for="generatorsource">generator:source</label><input type="text" name="generatorsource"/>
    <label for="pointname">name</label><input type="text" name="pointname"/>
    <label for="operator">operator</label><input type="text" name="operator"/>
    <label for="power">power</label><input type="text" name="power"/>
    <label for="power_source">power_source</label><input type="text" name="power_source"/>
    <label for="ref">ref</label><input type="text" name="ref"/>
    <label for="lon">longitude</label><input type="text" name="lon"/>
    <label for="lat">latidude</label><input type="text" name="lat"/><br />
    <input type="submit" name="send" value="Insert"/>
</form>
</body>
</html>