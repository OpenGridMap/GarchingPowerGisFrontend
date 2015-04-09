<html>
<head><title>Insert Data</title></head>
<body>
<?php
if (!empty($_GET['lat']) && !empty($_GET['lon'])) {
    $lonlat = '&lat=' . $_GET['lat'] . '&lon=' . $_GET['lon'];
} else {
    $lonlat = '';
}
?>
<a href="view.php">View planet_osm_point table</a><br /><br />
<a href="insert.php?type=substation<?php echo $lonlat; ?>">Add a substation</a><br />
<a href="insert.php?type=cabledistributioncabinet<?php echo $lonlat; ?>">Add a cable distribution cabinet</a><br />
<a href="insert.php?type=transformer<?php echo $lonlat; ?>">Add a transformer</a><br />
<a href="insert.php?type=tower<?php echo $lonlat; ?>">Add a tower</a><br />
<a href="insert.php?type=pole<?php echo $lonlat; ?>">Add a pole</a><br />
<a href="insert.php?type=generator<?php echo $lonlat; ?>">Add a generator</a><br />
<a href="insert.php?type=custom<?php echo $lonlat; ?>">Add a custom power tag</a><br /><br />
<a href="clearCache.php">Clear cache of power layer</a>
</body>
</html>