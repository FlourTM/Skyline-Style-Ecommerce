<?php
require 'vendor/autoload.php';
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

CacheManager::setDefaultConfig(new ConfigurationOption([
    'path' => 'cache',
]));

// In your class, function, you can call the Cache
$InstanceCache = CacheManager::getInstance('files');


$url = "https://us-east-1-shared-usea1-02.cdn.hygraph.com/content/clef67dhx6glt01uo3wv42tph/master";
$headers = array();
$headers[] = 'Content-Type: application/json';
$key = "products";
$CachedString = $InstanceCache->getItem($key);

$dictionary = [];

if (!$CachedString->isHit()) {
    $query = $data_string = json_encode([
        "query" => "query{products(first: 100){id,name,price,desc,sizing,section,subsection,slug,image{url}}}",
    ]);
   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $data = json_decode($result, true);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    for ($i = 0; $i < count($data['data']['products']); $i++) {
        $dataid = strval($data["data"]["products"][$i]["id"]);
        $dictionary[$dataid] = $data["data"]["products"][$i];
    }

    $query2 = $data_string = json_encode([
        "query" => "query{products(first: 100, skip: 100){id,name,price,desc,sizing,section,subsection,slug,image{url}}}",
    ]);

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $query2);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);

    $result2 = curl_exec($ch2);
    $data2 = json_decode($result2, true);

    if (curl_errno($ch2)) {
        echo 'Error:' . curl_error($ch2);
    }

    for ($i = 0; $i < count($data2['data']['products']); $i++) {
        $dataid = strval($data2["data"]["products"][$i]["id"]);
        $dictionary[$dataid] = $data2["data"]["products"][$i];
    }

    $CachedString->set($dictionary)->expiresAfter(3600);//in seconds, also accepts Datetime
    $InstanceCache->save($CachedString); // Save the cache item just like you do with doctrine and entities
    echo ('<script>window.location.reload()</script>');
} else {
    // echo 'READ FROM CACHE // ';
    $GLOBALS['cmstbl'] = $CachedString->get();
}