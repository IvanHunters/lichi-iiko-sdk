<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\Organization;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\ApiProvider;

class Organization implements OrganizationInterface
{

    private ApiProvider $apiProvider;
    public array $organizations;
    public string $firstOrganization;

    public function __construct(ApiProvider $apiProvider)
    {
        $this->apiProvider = $apiProvider;
        $this->organizations = $this->getOrganizations();
        $this->firstOrganization = $this->getFirst();
    }

    public function getFirst(): string
    {
        return array_key_first($this->organizations);
    }

    private function getOrganizations(): array
    {
        $response = $this->apiProvider->callMethod('POST', '/api/1/organizations', [
            RequestOptions::JSON => [
                'returnAdditionalInfo' => true,
                'includeDisabled' => true
            ]
        ]);
        $organizations =  $response['organizations'];
        return $this->beautifyOrganization($organizations);
    }

    private function beautifyOrganization(array $organizations): array
    {
        $cleanOrganizations = [];
        foreach ($organizations as $organization) {
            /** @var string $organizationName */
            $organizationName = $organization['name'];
            /** @var string $organizationId */
            $organizationId = $organization['id'];
            $cleanOrganizations[$organizationId] = $organizationName;
        }
        return $cleanOrganizations;
    }
}