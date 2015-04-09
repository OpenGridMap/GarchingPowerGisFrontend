<?php
include('config.inc.php');

$page = 1;
if (!empty($_GET['page']) && is_numeric($_GET['page'])) {
    $page = intval($_GET['page']);
}
$entries_per_page = 20;
$offset = ($page - 1) * $entries_per_page;

$dbconn = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS)
or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

$query = "SELECT osm_id, ST_X(way) as longitude, ST_Y(way) as latitude, power, name, ref, location, voltage, transformer, frequency, phases, rating, pole, substation, operator, gas_insulated, \"generator:source\", \"generator:method\", \"generator:type\", \"generator:plant\", count(*) OVER() AS total_count FROM planet_osm_point WHERE NOT power = '' ORDER BY osm_id DESC LIMIT 20 OFFSET $offset";

$result = pg_query($dbconn, $query);
if (pg_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>osm_id</th><th>power</th><th>name</th><th>ref</th><th>generator:source</th><th>voltage</th><th>operator</th><th>generator:method</th><th>generator:type</th><th>generator:plant</th><th>location</th><th>substation</th><th>transformer</th><th>frequency</th><th>phases</th><th>rating</th><th>pole</th><th>gas_insulated</th><th>Longitude</th><th>Latitude</th><th>Edit</th><th>Delete</th></tr>';
    while ($data = pg_fetch_object($result)) {
        echo '<tr>';
        echo '<td>' . $data->osm_id . '</td>';
        echo '<td>' . $data->power . '</td>';
        echo '<td>' . $data->name . '</td>';
        echo '<td>' . $data->ref . '</td>';
        echo '<td>' . $data->{'generator:source'} . '</td>';
        echo '<td>' . $data->voltage . '</td>';
        echo '<td>' . $data->operator . '</td>';
        echo '<td>' . $data->{'generator:method'} . '</td>';
        echo '<td>' . $data->{'generator:type'} . '</td>';
        echo '<td>' . $data->{'generator:plant'} . '</td>';
        echo '<td>' . $data->location . '</td>';
        echo '<td>' . $data->substation . '</td>';
        echo '<td>' . $data->transformer . '</td>';
        echo '<td>' . $data->frequency . '</td>';
        echo '<td>' . $data->phases . '</td>';
        echo '<td>' . $data->rating . '</td>';
        echo '<td>' . $data->pole . '</td>';
        echo '<td>' . $data->gas_insulated . '</td>';
        echo '<td>' . $data->longitude . '</td>';
        echo '<td>' . $data->latitude . '</td>';
        echo '<td><a href="edit.php?osm_id=' . $data->osm_id . '">Edit</a>';
        echo '<td><a href="delete.php?osm_id=' . $data->osm_id . '">Delete</a>';
        echo '</tr>';
    }
    echo '</table>';

    $total_count = pg_fetch_object($result, 0)->total_count;
    if ($page != 1) {
        echo '<a href="view.php?page=1">First</a>';
    }
    if ($page > 1) {
        echo '<a href="view.php?page=' . ($page - 1) . '">Prev</a>';
    }
    $page_max = ceil($total_count / $entries_per_page);
    if ($page < $page_max) {
        echo '<a href="view.php?page=' . ($page + 1) . '">Next</a>';
    }
    if ($page != $page_max) {
        echo '<a href="view.php?page=' . $page_max . '">Last</a>';
    }

} else {
    echo "No data available";
}