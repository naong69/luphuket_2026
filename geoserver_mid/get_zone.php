<?php
$newURL = $_POST['url'];
//echo "url=".$newURL;
$homepage = file_get_contents($newURL);
echo $homepage;



?>