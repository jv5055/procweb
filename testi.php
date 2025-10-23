<?php
ini_set("allow_url_fopen", 1);
$json = file_get_contents('https://www.unica.fi/menuapi/feed/json?costNumber=2000&language=fi');
$obj = json_decode($json, true);

function flatten($array, $prefix = '') {
    $result = [];

    foreach ($array as $key => $value) {
        $newKey = $prefix === '' ? $key : $prefix . '.' . $key;

        if (is_array($value)) {
            $result = array_merge($result, flatten($value, $newKey));
        } else {
            $result[$newKey] = $value;
        }
    }

    return $result;
}
$flat = flatten($obj['MenusForDays']);
print_r(array_values($flat));
?>
