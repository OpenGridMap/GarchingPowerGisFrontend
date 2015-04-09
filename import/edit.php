<?php
if (empty($_GET['osm_id']) or !is_numeric($_GET['osm_id'])) {
    header("Location: http://vmjacobsen34.informatik.tu-muenchen.de/import/view.php");
    exit;
}
include('config.inc.php');

$osm_id = intval($_GET['osm_id']);

$dbconn = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS)
or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

if (!isset($_POST['send'])) {
    $query = "SELECT osm_id, ST_X(way) AS longitude, ST_Y(way) AS latitude, power, name, ref, location, voltage, transformer, frequency, phases, rating, pole, substation, operator, gas_insulated, \"generator:source\", \"generator:method\", \"generator:type\", \"generator:plant\" FROM planet_osm_point WHERE osm_id = $osm_id";

    $result = pg_query($dbconn, $query);
    $num_rows = pg_num_rows($result);
    if ($num_rows == 1) {
        $data = pg_fetch_object($result);

        $lon = $data->longitude;
        $lat = $data->latitude;
        $power = $data->power;
        $name = $data->name;
        $ref = $data->ref;
        $location = $data->location;
        $voltage = $data->voltage;
        $transformer = $data->transformer;
        $frequency = $data->frequency;
        $phases = $data->phases;
        $rating = $data->rating;
        $pole = $data->pole;
        $substation = $data->substation;
        $operator = $data->operator;
        $gas_insulated = $data->gas_insulated;
        $generatorsource = $data->{'generator:source'};
        $generatormethod = $data->{'generator:method'};
        $generatortype = $data->{'generator:type'};
        $generatorplant = $data->{'generator:plant'};

        switch ($power) {
            case 'substation':
                $form = 'forms/substation.form.php';
                break;
            case 'sub_station':
                $form = 'forms/substation.form.php';
                break;
            case 'cabledistributioncabinet':
                $form = 'forms/cable_distribution_cabinet.form.php';
                break;
            case 'transformer':
                $form = 'forms/transformer.form.php';
                break;
            case 'tower':
                $form = 'forms/tower.form.php';
                break;
            case 'pole':
                $form = 'forms/pole.form.php';
                break;
            case 'generator':
                $form = 'forms/generator.form.php';
                break;
            default:
                $form = 'forms/custom.form.php';
        }
        include($form);

    } elseif ($num_rows == 0) {
        echo "No entry with osm_id $osm_id available";
    } elseif ($num_rows > 1) {
        echo "Error: More then one entry with osm_id $osm_id available";
    }

}

else {
    $error = false;
    $generatorsource = $generatormethod = $generatortype = $generatorplant = $name = $operator = $ref = $substation = '';
    $location = $voltage = $gas_insulated = $transformer = $frequency = $phases = $rating = $pole = $power = '';

    if (!empty($_POST['power'])) {
        $power = $_POST['power'];
    }
    if (!empty($_POST['generatorsource'])) {
        $generatorsource = $_POST['generatorsource'];
    }
    if (!empty($_POST['generatormethod'])) {
        $generatormethod = $_POST['generatormethod'];
    }
    if (!empty($_POST['generatortype'])) {
        $generatortype = $_POST['generatortype'];
    }
    if (!empty($_POST['generatorplant'])) {
        $generatorplant = $_POST['generatorplant'];
    }
    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
    }
    if (!empty($_POST['operator'])) {
        $operator = $_POST['operator'];
    }
    if (!empty($_POST['ref'])) {
        $ref = $_POST['ref'];
    }
    if (!empty($_POST['substation'])) {
        $substation = $_POST['substation'];
    }
    if (!empty($_POST['location'])) {
        $location = $_POST['location'];
    }
    if (!empty($_POST['voltage'])) {
        $voltage = $_POST['voltage'];
    }
    if (!empty($_POST['gas_insulated'])) {
        $gas_insulated = $_POST['gas_insulated'];
    }
    if (!empty($_POST['transformer'])) {
        $transformer = $_POST['transformer'];
    }
    if (!empty($_POST['frequency'])) {
        $frequency = $_POST['frequency'];
    }
    if (!empty($_POST['phases'])) {
        $phases = $_POST['phases'];
    }
    if (!empty($_POST['rating'])) {
        $rating = $_POST['rating'];
    }
    if (!empty($_POST['pole'])) {
        $pole = $_POST['pole'];
    }

    if (empty($power)) {
        echo 'Error: Please fill in "power"<br />';
        $error = true;
    }
    if (empty($_POST['lon']) && empty($_POST['lat'])) {
        echo "Error: Please fill in longitude and latidude";
        $error = true;
    } else {
        $lon = $_POST['lon'];
        $lat = $_POST['lat'];
        $cord_x = $lon;
        $cord_y = $lat;
        //$cord_x = lon2x($lon);
        //$cord_y = lon2x($lat);
    }

    if (!$error) {
        $query= "UPDATE planet_osm_point SET (way, power, name, ref, location, voltage, transformer, frequency, phases, rating, pole, substation, operator, gas_insulated, \"generator:source\", \"generator:method\", \"generator:type\", \"generator:plant\") = (ST_Geometry('SRID=900913;POINT($cord_x $cord_y)'), '$power', '$name', '$ref', '$location', '$voltage', '$transformer', '$frequency', '$phases', '$rating', '$pole', '$substation', '$operator', '$gas_insulated', '$generatorsource', '$generatormethod', '$generatortype', '$generatorplant') WHERE osm_id = $osm_id;";

        $result = pg_query($dbconn, $query);
        echo  "Query: " . $query;
        if (pg_affected_rows($result) == 0) {
            echo "Ein Fehler ist aufgetreten.\n" . pg_last_error();
            exit;
        } else {
            echo "Daten erfolgreich aktualisiert";
        }
    }
}