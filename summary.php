<?php
/*******************************************
 * Скрипт для сбора информации по параметрам
 * файла выгрузки Yandex Market Language
 *
 *
 */

$filename = $argv[1];
if (!file_exists($filename)) {
    exit("File $filename not found\n");
}

$intl = require_once __DIR__ . DIRECTORY_SEPARATOR . 'intl.php';
/*******************
 * functions
 */
function markSign(&$signs, $name, $tag)
{
    if (!$signs[$name] && $tag != null) {
        $signs[$name] = true;
    }
}

$_ = function ($translations, $name, $defaultLanguage = 'en') use ($intl) {
    return isset($translations[$name]) ? $translations[$name] : $intl[$defaultLanguage][$name];
};

function alphPrint($array, $implode_char = ', ')
{
    $prevCh = null;
    $first = true;
    foreach ($array as $v) {
        $ch = mb_substr($v, 0, 1);
        if ($prevCh !== $ch) {
            echo "\n$ch\n";
            $prevCh = $ch;
            $first = true;
        }
        if ($first) {
            echo $v;
            $first = false;
        } else
            echo $implode_char . $v;
    }
}

function mb_ucfirst($string, $encoding)
{
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

//////////////////////////////

$xml = simplexml_load_file($filename);
$shop = $xml->shop;
if ($shop == null)
    exit('Invalid content');
if (isset($argv[2]) && isset($intl[$argv[2]]))
    $t = $intl[$argv[2]];
else
    $t = $intl['en'];


echo "====================================\n";
echo $_($t, 'shop_name') . ": " . $shop->name . "\n";
echo $_($t, 'company_name') . ": " . $shop->company . "\n";
echo $_($t, 'company_url') . ": " . $shop->url . "\n";


$countRootCats = 0;
$totalCats = 0;
$catNames = [];
foreach ($shop->categories->category as $cat) {
    /** @var $cat SimpleXMLElement */
    $isRoot = $cat['parentId'] === null;
    if ($isRoot) $countRootCats++;
    $totalCats++;
    $catNames[] = $cat->__toString();
}
$catNames = array_unique($catNames);
sort($catNames);
echo "============ " . $_($t, 'categories') . " ============\n";
echo $_($t, 'total_cat_roots') . ": $countRootCats\n";
echo $_($t, 'total_cats') . ": $totalCats";
echo alphPrint($catNames) . "\n";

$params = [];
$pics = 0;
$offersCount = 0;
$offersCountAvailable = 0;
$signs = array(
    'delivery' => false,
    'url' => false,
    'price' => false,
    'opt_price' => false,
    'model' => false,
    'barcode' => false,
    'description' => false,
    'vendor' => false,
    'vendorCode' => false,
    'typePrefix' => false,
    'picture' => false,
    'id' => false,
);
$signKeys = array_keys($signs);
foreach ($shop->offers->offer as $offer) {
    $offersCount++;
    if ($offer['available']->__toString() === 'true')
        $offersCountAvailable++;
    markSign($signs, 'id', $offer['id']);
    foreach ($signKeys as $key)
        markSign($signs, $key, $offer->$key);
    $pics += $offer->picture->count();
    foreach ($offer->param as $p) {
        $name = mb_ucfirst(trim($p['name']), 'utf-8');
        if (!isset($params[$name])) {
            $unit = null;
            if (isset($p['unit'])) {
                $unit = $p['unit'];
            }
            $params[$name] = $unit;
        }
    }
}
echo "=============== " . $_($t, 'signs') . " ==============\n";
$c = 0;
foreach ($signKeys as $key) {
    if ($signs[$key]) {
        echo ++$c . '. ' . $_($t, $key) . "\n";
    }
}
ksort($params);
foreach ($params as $p => $unit) {
    if ($unit) {
        echo ++$c . '. ' . $p . ' (' . $unit . ")\n";
    }
}
echo "=============== " . $_($t, 'statistic') . " ==============\n";
echo $_($t, 'available_offers') . ": $offersCountAvailable / $offersCount\n";
if ($signs['picture']) {
    echo $_($t, 'avg_images') . ": " . number_format($pics / $offersCount, 2) . "\n";
}
