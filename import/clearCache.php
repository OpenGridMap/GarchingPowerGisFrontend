<html>
<head><title>clear cache</title></head>
<body>
<p>

<?php
$output = shell_exec('rm -rf /var/lib/mod_tile/poweronly 2>&1');
if (empty($output)) {
    echo 'cache cleared<br />';
} else {
    echo $output . '<br />';
}
echo shell_exec('service renderd restart 2>&1');
?>
</p>
</body>
</html>