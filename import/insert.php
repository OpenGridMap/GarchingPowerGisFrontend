<?php
include('config.inc.php');

if (empty($_GET['type'])) {
    header("Location: http://vmjacobsen34.informatik.tu-muenchen.de/import/");
    exit;
}
$error = false;
$type = $_GET['type'];

if (!empty($_GET['lon']) && !empty($_GET['lat']) && !isset($_POST['send'])) {
    $lon = $_GET['lon'];
    $lat = $_GET['lat'];
} else {
    $lon= '';
    $lat = '';
}

$generatorsource = $generatormethod = $generatortype = $generatorplant = $name = $operator = $ref = $substation = '';
$location = $voltage = $gas_insulated = $transformer = $frequency = $phases = $rating = $pole = $power = '';


switch ($type) {
    case 'substation':
        $form = 'forms/substation.form.php';
        $power = 'substation';
        break;
    case 'cabledistributioncabinet':
        $form = 'forms/cable_distribution_cabinet.form.php';
        $power = 'cable_distribution_cabinet';
        break;
    case 'transformer':
        $form = 'forms/transformer.form.php';
        $power = 'transformer';
        break;
    case 'tower':
        $form = 'forms/tower.form.php';
        $power = 'tower';
        break;
    case 'pole':
        $form = 'forms/pole.form.php';
        $power = 'pole';
        break;
    case 'generator':
        $form = 'forms/generator.form.php';
        $power = 'generator';
        break;
    case 'custom':
        $form = 'forms/custom.form.php';
        if (!empty($_POST['power'])) {
            $power = $_POST['power'];
        }
        break;
    default:
        echo 'Failure! Please go back to <a href="index.php">http://vmjacobsen34.informatik.tu-muenchen.de/import/</a>';
}


if (isset($_POST['send'])) {
    $dbconn = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS)
    or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

    $query = 'select osm_id from planet_osm_point order by osm_id desc limit 1;';
    $result = pg_query($dbconn, $query) or die('Fehler bei Abfrage der osm_id: ' . pg_last_error());
    $data = pg_fetch_array($result, null, PGSQL_ASSOC);
    $osm_id = $data['osm_id'] + 1;
    if ($osm_id < 999999999990000) {
        $osm_id = 999999999990000;
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
        $query = "INSERT INTO planet_osm_point (osm_id, way, power, name, ref, location, voltage, transformer, frequency, phases, rating, pole, substation, operator, gas_insulated, \"generator:source\", \"generator:method\", \"generator:type\", \"generator:plant\") VALUES ($osm_id, ST_Geometry('SRID=900913;POINT($cord_x $cord_y)'), '$power', '$name', '$ref', '$location', '$voltage', '$transformer', '$frequency', '$phases', '$rating', '$pole', '$substation', '$operator', '$gas_insulated', '$generatorsource', '$generatormethod', '$generatortype', '$generatorplant');";
        $result = pg_query($dbconn, $query);
        echo  "Query: " . $query;
        if (pg_affected_rows($result) == 0) {
            echo "Ein Fehler ist aufgetreten.\n" . pg_last_error();
            exit;
        } else {
            echo "Daten erfolgreich eingetragen";
        }
    }

}
if (isset($form)) {
    include($form);
}


/**
switch ($power) {
    case 'substation':
        include('forms/substation.form.php');
        break;
    case 'cabledistributioncabinet':
        include('forms/cable_distribution_cabinet.form.php');
        break;
    case 'transformer':
        include('forms/transformer.form.php');
        break;
    case 'tower':
        include('forms/tower.form.php');
        break;
    case 'pole':
        include('forms/pole.form.php');
        break;
    case 'generator':
        include('forms/generator.form.php');
        break;
    case 'custom':
        include('forms/custom.form.php');
        break;
    default:
        echo 'Failure! Please go back to <a href="index.php">http://vmjacobsen34.informatik.tu-muenchen.de/import/</a>';
}
**/

function lon2x($lon) { return deg2rad($lon) * 6378137.0; }
function lat2y($lat) { return log(tan(M_PI_4 + deg2rad($lat) / 2.0)) * 6378137.0; }