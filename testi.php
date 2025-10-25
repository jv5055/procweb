<?php
ini_set("allow_url_fopen", 1);
$json = file_get_contents('https://www.unica.fi/menuapi/feed/json?costNumber=198501&language=fi');
$obj = json_decode($json, true);

//litistetään toi kirottu nested array helpommaksi käsitellä
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

//poistetaan turhat key-value parit
foreach ($flat as $key => $value) {
    if (preg_match("/SortOrder|date/i", $key) == true) {
        unset($flat[$key]);
    }
    if (str_starts_with($key, '1.')) {
        unset($flat[$key]);
    }
}
print_r($flat);
?>
