<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCloud\Dictionary;


use Lichi\Iiko\ApiProvider;

class Dictionary
{

    public Discount $discount;
    public Order $order;
    public Payment $payment;
    public Removal $removal;

    public function __construct(ApiProvider $apiProvider, string $organizationId){
        $this->discount = new Discount($apiProvider, $organizationId);
        $this->order = new Order($apiProvider, $organizationId);
        $this->payment = new Payment($apiProvider, $organizationId);
        $this->removal = new Removal($apiProvider, $organizationId);
    }

}