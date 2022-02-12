<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\Order;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\ApiProvider;

class Order
{

    private ApiProvider $apiProvider;
    public OrderContainer $orderData;
    private string $organizationId;

    public function __construct(ApiProvider $apiProvider, string $organizationId)
    {
        $this->apiProvider = $apiProvider;
        $this->organizationId = $organizationId;
        $this->orderData = new OrderContainer($organizationId);
    }

    public function setOrganizationId(string $organizationId): self
    {
        $this->organizationId = $organizationId;
        return $this;
    }

    public function check(){
        $orderData = $this->orderData->export();
        return $this->apiProvider->callMethod(
            "POST",
            "/api/1/deliveries/check_create",
            [
                RequestOptions::JSON => $orderData
            ]
        );
    }

    public function calculate(){
        $orderData = $this->orderData->export();
        return $this->apiProvider->callMethod(
            "POST",
            "/api/1/loyalty/iiko/calculate_checkin",
            [
                RequestOptions::JSON => $orderData
            ]
        );
    }

    public function create(){
        $orderData = $this->orderData->export();
        return $this->apiProvider->callMethod(
            "POST",
            "/api/1/order/create",
            [
                RequestOptions::JSON => $orderData
            ]
        );
    }

    public function searchOrder(string $orderId): array
    {
        return $this->apiProvider->callMethod(
            "POST",
            "/api/1/order/by_id",
            [
                RequestOptions::JSON => [
                    'organizationIds' => [$this->organizationId],
                    'orderIds' => [$orderId]
                ]
            ]
        );
    }

    public function cancel(string $orderId) {
        return $this->apiProvider->callMethod(
            "POST",
            "/api/1/order/close",
            [
                RequestOptions::JSON => [
                    'organizationId' => $this->organizationId,
                    'orderId' => $orderId
                ]
            ]
        );
    }
}