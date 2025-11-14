<?php
ini_set("allow_url_fopen", 1);
$kisalli = json_decode(file_get_contents('https://www.unica.fi/menuapi/feed/json?costNumber=1900&language=fi'), true);
$linus = json_decode(file_get_contents('https://www.unica.fi/menuapi/feed/json?costNumber=2000&language=fi'), true);
$delica = json_decode(file_get_contents('https://www.unica.fi/menuapi/feed/json?costNumber=1985&language=fi'), true);

$obj = json_decode(file_get_contents('https://www.unica.fi/menuapi/feed/json?costNumber=198501&language=fi'), true);

//litistetään toi kirottu nested array helpommaksi käsitellä, ja poistetaan turhat key-value parit
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
    //poistetaan turhat key-value parit
    foreach ($result as $key => $value) {
        if (preg_match("/SortOrder|date/i", $key) == true) {
            unset($result[$key]);
        }
        if (str_starts_with($key, '1.')) {
            unset($result[$key]);
        }
    }

    return $result;
}
$menu_kisalli = flatten($kisalli['MenusForDays']);
$menu_linus = flatten($linus['MenusForDays']);
$menu_delica = flatten($delica['MenusForDays']);

print_r($menu_kisalli);
print_r($menu_linus);
print_r($menu_delica);

?>
