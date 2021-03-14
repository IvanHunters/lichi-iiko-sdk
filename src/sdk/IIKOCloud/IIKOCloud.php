<?php


namespace Lichi\Iiko\Sdk\IIKOCloud;

use Lichi\Iiko\ApiProvider;
use Lichi\Iiko\Sdk\IIKOCloud\Address\Address;
use Lichi\Iiko\Sdk\IIKOCloud\Order\Order;
use Lichi\Iiko\Sdk\IIKOCloud\Organization\Organization;
use Lichi\Iiko\Sdk\IIKOCloud\Nomenclature\Nomenclature;

class IIKOCloud implements IIKOCloudInterface
{


    /**
     * @var ApiProvider
     */
    private ApiProvider $provider;
    public Nomenclature $nomenclature;
    public Organization $organization;
    public Address $address;

    public function __construct(ApiProvider $provider)
    {
        $this->provider = $provider;
        $this->organization = new Organization($provider);
        $this->nomenclature = new Nomenclature($provider, $this->organization->firstOrganization);
        $this->address = new Address($provider, $this->organization->firstOrganization);
    }
}