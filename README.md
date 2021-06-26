Email for cooperation: offers@lichi.su

# lichi-iiko-sdk
**For install:**
```
composer require lichi/iiko-sdk
```

**Calling the constructor to get started**

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


**Dictionary IIKO Cloud**
```
$getDiscountData = $iikoCloud->dictionary->discount->get();
$getOrderData = $iikoCloud->dictionary->order->get();
$getPaymentData = $iikoCloud->dictionary->payment->get();
$getRemovalData = $iikoCloud->dictionary->removal->get();
```


**Nomenclature**
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

**Order**
```
$order = $iikoCloud->order;

# Create order
## Set order container
    $order->orderData->setCustomerInfo(['id' => 'Customer id from iiko']);
    $order->orderData->setCustomerInfo(['name' => 'Customer name']);

    $order->orderData->setPhone('+79996288989');
    $order->orderData->setDeliveryPoint([
        'street' => [
            'city' => City,
            'name' => Street name (Street must be filled in the Streets directory
        ],
        'house' => house,
        'building' => building,
        'floor' => floor,
        'entrance' => entrance
    ]);

    $order->orderData->setComment('comment');
    $order->orderData->setItems([
        [
            'productId' => product_id,
            'price' => price,
            'amount' => amount,
            'type' => 'Product'
        ]
    ]);

    $order->orderData->setOrderServiceType( 'DeliveryByCourier' OR 'DeliveryByClient' );
    $order->orderData->setTerminalGroupId($iikoCloud->terminalGroup->getFirstTerminalGroup());
    
    $order->orderData->setDiscount($fields['coupon']);

    $order->orderData->setPayments([
        [
            'paymentTypeKind' => 'Card',
            'sum' => sum,
            'paymentTypeId' => paymentTypeId (FROM payment dictionary),
            'isProcessedExternal' => false,
            'paymentAdditionalData' => [ //optional
                "credential" => '+79999999999',
                "searchScope" => "Phone"
            ]
        ],
        [
            'paymentTypeKind' => 'IikoCard',
            'sum' => sum,
            'paymentTypeId' => paymentTypeId (FROM payment dictionary),
            'isProcessedExternal' => false
        ],
        [
            'paymentTypeKind' => 'Cash',
            'sum' => sum,
            'paymentTypeId' => paymentTypeId (FROM payment dictionary),
            'isProcessedExternal' => false
        ]
    ]);

#Order actions
$order->check();
$order->create();

$order->calculate(); //If you use coupon
$order->searchOrder($id); //Use order_id to search for an order

```


**Customers**

# Login | Get customers info use phone number
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