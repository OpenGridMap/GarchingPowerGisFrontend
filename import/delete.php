<?php
if (empty($_GET['osm_id']) or !is_numeric($_GET['osm_id'])) {
    header("Location: http://vmjacobsen34.informatik.tu-muenchen.de/import/view.php");
    exit;
}
include('config.inc.php');

$osm_id = intval($_GET['osm_id']);

if (!isset($_POST['delete']) && !isset($_POST['abort'])) {
    echo 'Do you really want delete osm_id ' . $osm_id . '?';
    ?>

    <form name = "confirmation" method = "post" >
        <input type = "submit" name = "abort" value = "Abort" />
        <input type = "submit" name = "delete" value = "Delete" />
    </form>

    <?php
} else {
    if (!empty($_POST['abort'])) {
        header("Location: http://vmjacobsen34.informatik.tu-muenchen.de/import/view.php");
    } else {
        $dbconn = pg_connect('host=' . DB_HOST . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASS)
        or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

        $query= "DELETE FROM planet_osm_point WHERE osm_id = $osm_id;";

        $result = pg_query($dbconn, $query);
        if (pg_affected_rows($result) == 0) {
            echo "Failure:\n" . pg_last_error();
            exit;
        } else {
            echo 'ID ' . $osm_id . ' successfully deleted<br /><a href="view.php">Back to overview</a>';
        }
    }

}
