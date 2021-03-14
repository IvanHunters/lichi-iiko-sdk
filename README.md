# lichi-iiko-sdk
**For install:**
```
composer require lichi/vk-iiko-sdk
```

**Simple work with grabbing system**

```
include "vendor/autoload.php";

use Lichi\Iiko\Sdk\IIKOCloud\IIKOCloud;
use Lichi\Iiko\ApiProvider;
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => "https://api-ru.iiko.services",
    'verify' => false,
    'timeout'  => 30.0,
]);

$apiProvider = new ApiProvider($client, getenv('API_KEY'));
$iikoCloud = new IIKOCloud($apiProvider);
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