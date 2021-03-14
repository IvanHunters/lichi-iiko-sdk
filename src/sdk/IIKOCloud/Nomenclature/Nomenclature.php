<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\Nomenclature;


use GuzzleHttp\RequestOptions;
use Lichi\Iiko\ApiProvider;

class Nomenclature implements NomenclatureInterface
{

    private ApiProvider $apiProvider;
    private string $organizationId;
    private array $products;
    private array $groups;
    private array $productCategories;
    private int $revision;

    public function __construct(ApiProvider $apiProvider, string $organizationId)
    {
        $this->apiProvider = $apiProvider;
        $this->organizationId = $organizationId;
    }

    public function setOrganizationId(string $organizationId): Nomenclature
    {
        $nomenclature = clone $this;
        $nomenclature->organizationId = $organizationId;
        return $nomenclature->getNomenclature();
    }

    public function getGroups(array $fields = ['id', 'name']): array
    {
        return $this->getDataUseFields($this->groups, $fields, []);
    }

    public function getProductCategories(array $fields = []): array
    {
        return $this->getDataUseFields($this->productCategories, $fields, []);
    }

    public function getProducts(array $fields = [], array $validation = []): array
    {
        return $this->getDataUseFields($this->products, $fields, $validation);
    }

    public static function linkProductsWithGroups(array $groups, array $products): array
    {
        $groupsData = [];
        $newProducts = [];

        foreach ($groups as $group) {
            $groupsData[$group['id']] = $group['name'];
            $d[$group['name']] = $group['id'];
        }

        foreach ($products as $product)
        {
            $groupId = $product['parentGroup'];
            if (isset($groupsData[$groupId])) {
                $groupName = $groupsData[$groupId];
                $product['groupName'] = $groupName;
            } else {
                $product['groupName'] = 'Неизвестно';
            }
            unset($products['groupId']);
            $newProducts[] = $product;

        }
        return $newProducts;
    }

    private function getDataUseFields(array $place, array $fields = [], array $validationPlace): array
    {
        $resultData = [];
        /** @var array $placeData */
        foreach($place as $placeData) {
            $validatedPlace = [];
            /**
             * @var string $fieldName
             * @var string|array|int $fieldValue
             */
            foreach ($placeData as $fieldName => $fieldValue) {
                if (in_array($fieldName, $fields) && count($fields) > 0) {
                    if(isset($validationPlace[$fieldName]) && is_callable($validationPlace[$fieldName])) {
                        $fieldValue = $validationPlace[$fieldName]($placeData, $fieldValue);
                        if ($fieldValue === -1) {
                            $validatedPlace = [];
                            break;
                        }
                    }
                    $validatedPlace[$fieldName] = $fieldValue;
                }
            }
            if (count($validatedPlace) > 0) {
                $resultData[] = $validatedPlace;
            }
        }
        return $resultData;
    }

     public function getRevision(): int
    {
        return $this->revision;
    }

    public function getNomenclature(): Nomenclature
    {
        $nomenclature = $this->apiProvider->callMethod(
            "POST",
            "/api/1/nomenclature",
            [
                RequestOptions::JSON => [
                    'organizationId' => $this->organizationId,
                ]
            ]
        );

        $this->groups = $nomenclature['groups'];
        $this->productCategories = $nomenclature['productCategories'];
        $this->products = $nomenclature['products'];
        $this->revision = $nomenclature['revision'];
        return clone $this;
    }
}