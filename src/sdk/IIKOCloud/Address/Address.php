<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\Address;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\ApiProvider;

class Address
{
    protected ApiProvider $apiProvider;
    protected string $organizationId;

    public function __construct(ApiProvider $apiProvider, string $organizationId)
    {
        $this->apiProvider = $apiProvider;
        $this->organizationId = $organizationId;
    }

    public function getCities(): array
    {
        $response = $this->apiProvider->callMethod(
            "POST",
            "/api/1/cities",
            [
                RequestOptions::JSON => [
                    'organizationIds' => [$this->organizationId],
                ]
            ]
        );
        return $response['cities'];
    }

    public function getRegions(): array
    {
        $response = $this->apiProvider->callMethod(
            "POST",
            "/api/1/regions",
            [
                RequestOptions::JSON => [
                    'organizationIds' => [$this->organizationId],
                ]
            ]
        );
        return $response['regions'];
    }

    public function getStreetByCity(string $cityId): array
    {
        $response = $this->apiProvider->callMethod(
            "POST",
            "/api/1/by_city",
            [
                RequestOptions::JSON => [
                    'organizationIds' => [$this->organizationId],
                    'cityId' => $cityId
                ]
            ]
        );
        return $response['streets'];
    }

    public function setOrganizationId(string $organizationId): void
    {
        $this->organizationId = $organizationId;
        $this->city->setOrganizationId($organizationId);
        $this->region->setOrganizationId($organizationId);
    }
}