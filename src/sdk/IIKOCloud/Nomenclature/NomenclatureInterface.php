<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\Nomenclature;


use Lichi\Iiko\ApiProvider;

interface NomenclatureInterface
{
    public function __construct(ApiProvider $apiProvider, string $organizationId);
    public function setOrganizationId(string $organizationId): Nomenclature;
    public function getGroups(): array;
    public function getProducts(array $fields): array;

}