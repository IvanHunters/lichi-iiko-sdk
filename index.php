<?php

include "vendor/autoload.php";

use Lichi\Iiko\ApiProvider;
use GuzzleHttp\Client;
use Lichi\Iiko\Sdk\IIKOCloud\IIKOCloud;

$client = new Client([
    'base_uri' => "https://api-ru.iiko.services",
    'verify' => false,
    'timeout'  => 30.0,
]);

$clientCard = new Client([
    'base_uri' => "https://iiko.biz:9900/",
    'verify' => false,
    'timeout'  => 30.0,
]);

//$apiProviderCard = new CardApiProvider($clientCard, getenv('API_LOGIN'), getenv('API_PASS'));
//$iikoCard = new IIKOCard($apiProviderCard);

$apiProviderCloud = new ApiProvider($client, getenv('API_KEY'));
$iikoCloud = new IIKOCloud($apiProviderCloud);
