<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCloud\Authorization;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\ApiProvider;

class Login
{
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

    public function login(string $phone): ?array
    {
        try{
            $userData = $this->apiProvider->callMethod(
                "POST",
                "/api/1/loyalty/iiko/get_customer",
                [
                    RequestOptions::JSON => [
                        'organizationId' => $this->organizationId,
                        'type' => 'phone',
                        'phone' => $phone
                    ]
                ]
            );
        } catch (\Exception $e){
            return null;
        }
        return $userData;
    }

}