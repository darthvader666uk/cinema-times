<?php
$link = mysql_connect('localhost', 'root', 'sTu4rT321');
if (!$link) {
die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_close($link);
?>
