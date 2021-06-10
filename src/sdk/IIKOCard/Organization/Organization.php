<?php


namespace Lichi\Iiko\Sdk\IIKOCard\Organization;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\CardApiProvider;

class Organization implements OrganizationInterface
{

    private CardApiProvider $apiProvider;
    public array $organizations;
    public string $firstOrganization;

    public function __construct(CardApiProvider $apiProvider)
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
        $response = $this->apiProvider->callMethod('GET',
            '/api/0/organization/list',
            []);
        return $this->beautifyOrganization($response);
    }

    private function beautifyOrganization(array $organizations): array
    {
        $cleanOrganizations = [];
        foreach ($organizations as $organization) {
            /** @var string $organizationName */
            $organizationName = $organization['fullName'];
            /** @var string $organizationId */
            $organizationId = $organization['id'];
            $cleanOrganizations[$organizationId] = $organizationName;
        }
        return $cleanOrganizations;
    }
}