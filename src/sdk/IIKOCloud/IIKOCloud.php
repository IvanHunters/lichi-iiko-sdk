<?php


namespace Lichi\Iiko\Sdk\IIKOCloud;

use Lichi\Iiko\ApiProvider;
use Lichi\Iiko\Sdk\IIKOCloud\Address\Address;
use Lichi\Iiko\Sdk\IIKOCloud\Dictionary\Dictionary;
use Lichi\Iiko\Sdk\IIKOCloud\Order\Order;
use Lichi\Iiko\Sdk\IIKOCloud\Organization\Organization;
use Lichi\Iiko\Sdk\IIKOCloud\Nomenclature\Nomenclature;
use Lichi\Iiko\Sdk\IIKOCloud\Status\Status;
use Lichi\Iiko\Sdk\IIKOCloud\TerminalGroup\TerminalGroup;

class IIKOCloud implements IIKOCloudInterface
{


    /**
     * @var ApiProvider
     */
    private ApiProvider $provider;
    public Nomenclature $nomenclature;
    public Organization $organization;
    public Address $address;
    public Order $order;
    public TerminalGroup $terminalGroup;
    public Status $status;
    public Dictionary $dictionary;

    public function __construct(ApiProvider $provider)
    {
        $this->provider = $provider;
        $this->organization = new Organization($provider);
        $this->terminalGroup = new TerminalGroup($provider, $this->organization->firstOrganization);
        $this->order = new Order($provider, $this->organization->firstOrganization);
        $this->nomenclature = new Nomenclature($provider, $this->organization->firstOrganization);
        $this->address = new Address($provider, $this->organization->firstOrganization);
        $this->status = new Status($provider, $this->organization->firstOrganization);
        $this->dictionary = new Dictionary($provider, $this->organization->firstOrganization);
    }
}