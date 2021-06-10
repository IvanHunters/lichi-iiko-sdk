<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCloud\Loyalty;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\ApiProvider;

class Loyalty
{
    /**
     * @var ApiProvider
     */
    private ApiProvider $apiProvider;
    private string $organizationId;

    public function __construct(ApiProvider $apiProvider, string $organizationId)
    {
        $this->apiProvider = $apiProvider;
        $this->organizationId = $organizationId;
    }

    public function setOrganizationId(string $organizationId): void
    {
        $this->organizationId = $organizationId;
    }

    public function getCustomerInfo(string $phone): array
    {
        try {
            $customerInfo = $this->apiProvider->callMethod(
                "POST",
                "/api/1/loyalty/iiko/get_customer",
                [
                    RequestOptions::JSON => [
                        'organizationId' => $this->organizationId,
                        'type' => 'phone',
                        'phone' => $phone,
                    ]
                ]
            );
        } catch (\RuntimeException $exception) {
            return [];
        }

        return $customerInfo;
    }

}