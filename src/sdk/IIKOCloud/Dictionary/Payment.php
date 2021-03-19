<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCloud\Dictionary;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\ApiProvider;

class Payment
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

    public function get(): array
    {
        return $this->apiProvider->callMethod(
            "POST",
            "/api/1/payment_types",
            [
                RequestOptions::JSON => ['organizationIds' => [$this->organizationId]]
            ]
        );
    }
}