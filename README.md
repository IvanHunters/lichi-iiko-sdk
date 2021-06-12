# Mail for cooperation: offers@lichi.su

# lichi-iiko-sdk
**For install:**
```
composer require lichi/vk-iiko-sdk
```

**Simple work with grabbing system**

```
include "vendor/autoload.php";

use Lichi\Iiko\Sdk\IIKOCloud\IIKOCloud;
use Lichi\Iiko\Sdk\IIKOCard\IIKOCard;
use Lichi\Iiko\ApiProvider;
use Lichi\Iiko\CardApiProvider;
use GuzzleHttp\Client;

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

$apiProviderCard = new CardApiProvider($clientCard, getenv('API_LOGIN'), getenv('API_PASS'));
$iikoCard = new IIKOCard($apiProviderCard);

$apiProviderCloud = new ApiProvider($client, getenv('API_KEY'));
$iikoCloud = new IIKOCloud($apiProviderCloud);
```

**Work with nomenclature**
```
$nomenclature = $iikoCloud->nomenclature->getNomenclature();
$products = $nomenclature->getProducts(
    [
        'id',
        'name',
        'tags',
        'groupId',
        'parentGroup',
        'imageLinks',
        'tags',
        'sizePrices',
        'type',
        'weight',
        'isDeleted',
        'orderItemType'
    ],
    [
        'imageLinks' => function ($placeData, $fieldValue){
            if(count($fieldValue) === 0){
                return -1;
            }
            return $fieldValue;
        },
        'sizePrices' => function ($placeData, $fieldValue) {
            return $fieldValue[0]['price']['currentPrice'];
        }
    ]);
$groups = $nomenclature->getGroups();
$productWithGroupName = $nomenclature::linkProductsWithGroups($groups, $products);
```

**Work with authorize**

# Login
```
$userData = $iikoCloud->authorization->login->login('phone_number');
```

# Registration
```
$userInfo = new CustomerForImport([
    'name' => 'Name',
    'phone' => 'Phone',
    'birthday' => 'YYYY-MM-DD',
]);
$userId = $iikoCard->registration->registration($userInfo);
```
