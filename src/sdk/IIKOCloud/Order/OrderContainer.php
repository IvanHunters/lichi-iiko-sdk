<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\Order;


use DateTime;
use RuntimeException;

class OrderContainer
{
    public string $organizationId;
    private array $order = [];
    private string $phone = '+79999999999';
    private array $customerInfo = [];
    private array $items = [];
    private array $combos = [];
    private array $payments = [];
    private string $discountsInfo = '';
    private array $deliveryPoint = [];
    private string $orderServiceType = '';
    private string $comment = '';
    private string $terminalGroupId = '';
    private string $coupon = '';
    private string $sourceKey = '';

    public function __construct(string $organizationId)
    {
        if (empty($organizationId))
        {
            throw new RuntimeException('Organization id is required!');
        }
        $this->organizationId = $organizationId;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setCustomerInfo(array $customerInfo): self
    {
        if(!isset($customerInfo['id'])) {
            if (!isset($customerInfo['name']) || (isset($customerInfo['name']) && empty($customerInfo['name'])))
            {
                throw new RuntimeException('Customer name is required!');
            }
        }

        if (isset($customerInfo['gender']) && !in_array($customerInfo['gender'], ['NotSpecified', 'Male', 'Female']))
        {
            $customerInfo['gender'] = 'NotSpecified';
        }

        if (isset($customerInfo['birthdate']))
        {
            $date = DateTime::createFromFormat('Y-m-d h:i:s \G\M\T', $customerInfo['birthdate']);
            if (!$date || !$date->format('Y-m-d h:i:s \G\M\T') == $customerInfo['birthdate']) {
                $customerInfo['birthdate'] = date('Y-m-d h:i:s \G\M\T');
            }
        }

        $this->customerInfo = $customerInfo;
        return $this;
    }

    public function setOrder(array $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function setItems(array $items): self
    {
        if(count($items) === 0){
            throw new RuntimeException('Items array not been empty!');
        }
        foreach ($items as $item) {
            if ($item['type'] !== 'Compound')
            {
                if (!isset($item['productId']) || (isset($item['productId']) && empty($item['productId']))) {
                    throw new RuntimeException('productId is required for Item!');
                }
            }
            if (!isset($item['amount']) || (isset($item['amount']) && empty($item['amount']))) {
                throw new RuntimeException('amount is required for Item!');
            }
        }
        $this->items = $items;
        return $this;
    }

    public function setCombos(array $combos): self
    {
        if(count($combos) === 0){
            throw new RuntimeException('Combos array not been empty!');
        }
        foreach ($combos as $combo)
        {
            if (!isset($combo['id']) || (isset($combo['id']) && empty($combo['id']))) {
                throw new RuntimeException('id is required for combo!');
            }
            if (!isset($combo['name']) || (isset($combo['name']) && empty($combo['name']))) {
                throw new RuntimeException('name is required for combo!');
            }
            if (!isset($combo['amount']) || (isset($combo['amount']) && empty($combo['amount']))) {
                throw new RuntimeException('amount is required for combo!');
            }
            if (!isset($combo['price']) || (isset($combo['price']) && empty($combo['price']))) {
                throw new RuntimeException('price is required for combo!');
            }
            if (!isset($combo['sourceId']) || (isset($combo['sourceId']) && empty($combo['sourceId']))) {
                throw new RuntimeException('sourceId is required for combo!');
            }
        }
        $this->combos = $combos;
        return $this;
    }

    public function setPayments(array $payments): self
    {
        foreach ($payments as $payment){
            if (
                !isset($payment['paymentTypeKind']) ||
                !in_array(
                    $payment['paymentTypeKind'],
                    [
                        'Cash',
                        'Card',
                        'IikoCard',
                        'External'
                    ]
                )
            ) {
                $payment['paymentTypeKind'] = 'Cash';
            }
            if (!isset($payment['sum']) || (isset($payment['sum']) && empty($payment['sum']))) {
                throw new RuntimeException('sum is required!');
            }
            if (!isset($payment['paymentTypeId']) || (isset($payment['paymentTypeId']) && empty($payment['paymentTypeId']))) {
                throw new RuntimeException('paymentTypeId is required!');
            }
        }
        $this->payments = $payments;
        return $this;
    }

    public function setDiscount(string $track): self
    {
        if (empty($track)) {
            throw new RuntimeException('Track code not been empty!');
        }
        $this->discountsInfo = $track;
        $this->coupon = $track;
        return $this;
    }

    public function setOrganizationId(string $organizationId): self
    {
        $this->organizationId = $organizationId;
        return $this;
    }

    public function setDeliveryPoint(array $address): self
    {
        if (count($address) === 0)
        {
            throw new RuntimeException('Delivery address not be empty!');
        }
        if (!isset($address['street']) || (isset($address['street']) && count($address['street']) === 0))
        {
            throw new RuntimeException('Delivery street is required!');
        }
        if (!isset($address['house']) || (isset($address['house']) && empty($address['house'])))
        {
            throw new RuntimeException('Delivery house is required!');
        }
        $this->deliveryPoint = $address;
        return $this;
    }

    public function setOrderServiceType(string $type = ''): self
    {
        if(!in_array($type, ['DeliveryByCourier', 'DeliveryByClient'])) {
            $type = 'DeliveryByCourier';
        }
        $this->orderServiceType = $type;
        return $this;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function setTerminalGroupId(string $terminalGroupId): self
    {
        $this->terminalGroupId = $terminalGroupId;
        return $this;
    }

    public function setSourceKey(string $sourceKey = ''): self
    {
        if (empty($sourceKey)) {
            throw new RuntimeException('source key not been empty!');
        }
        $this->sourceKey = $sourceKey;
        return $this;
    }

    public function export(): array
    {
        $response = [];
        $response['organizationId'] = $this->organizationId;

        if (count($this->order) === 0)
        {
            if (count($this->customerInfo) !== 0) {
                $response['order']['customer'] = $this->customerInfo;
            } else {
                throw new RuntimeException('Customer is required for order!');
            }
            if (!empty($this->terminalGroupId)) {
                $response['terminalGroupId'] = $this->terminalGroupId;
            } else {
                throw new RuntimeException('terminalGroupId is required!');
            }

            $response['order']['phone'] = $this->phone;
            if (count($this->items) === 0)
            {
                throw new RuntimeException('Items is required for order!');
            }
            $response['order']['items'] = $this->items;
            if (count($this->combos) !== 0) {
                $response['order']['combos'] = $this->combos;
            }
            if (count($this->payments) !== 0) {
                $response['order']['payments'] = $this->payments;
            }
            if (count($this->deliveryPoint) !== 0) {
                $response['order']['deliveryPoint']['address'] = $this->deliveryPoint;
            }
            if (!empty($this->coupon)) {
                $response['order']['iikoCard5Info']['coupon'] = $this->coupon;
                $response['coupon'] = $this->coupon;
            }
            if (!empty($this->orderServiceType)) {
                $response['order']['orderServiceType'] = $this->orderServiceType;
            } else {
                throw new RuntimeException('orderServiceType not be empty!');
            }
            if (!empty($this->sourceKey)) {
                $response['sourceKey'] = $this->sourceKey;
            }
            $response['order']['comment'] = $this->comment;
        } else {
            $response['order'] = $this->order;
        }
        if (!isset($response['order'])) {
            throw new RuntimeException('Order not been empty!');
        }
        return $response;
    }

}