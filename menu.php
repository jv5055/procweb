<?php
ini_set("allow_url_fopen", 1);
$json = file_get_contents('https://www.unica.fi/menuapi/feed/json?costNumber=1985&language=fi');
$obj = json_decode($json, true);
print_r($obj);



?>
