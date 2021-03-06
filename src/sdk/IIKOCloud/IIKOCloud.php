<?php


namespace Lichi\Iiko\Sdk\IIKOCloud;

use Lichi\Iiko\ApiProvider;
use Lichi\Iiko\Sdk\IIKOCloud\Address\Address;
use Lichi\Iiko\Sdk\IIKOCloud\Authorization\Authorization;
use Lichi\Iiko\Sdk\IIKOCloud\Dictionary\Dictionary;
use Lichi\Iiko\Sdk\IIKOCloud\Loyalty\Loyalty;
use Lichi\Iiko\Sdk\IIKOCloud\Order\Delivery;
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
    public Loyalty $loyalty;
    public Authorization $authorization;
    public Delivery $delivery;

    public function __construct(ApiProvider $provider)
    {
        $this->provider = $provider;
        $this->organization = new Organization($provider);
        $this->authorization = new Authorization($provider, $this->organization->firstOrganization);
        $this->loyalty = new Loyalty($provider, $this->organization->firstOrganization);
        $this->terminalGroup = new TerminalGroup($provider, $this->organization->firstOrganization);
        $this->order = new Order($provider, $this->organization->firstOrganization);
        $this->delivery = new Delivery($provider, $this->organization->firstOrganization);
        $this->nomenclature = new Nomenclature($provider, $this->organization->firstOrganization);
        $this->address = new Address($provider, $this->organization->firstOrganization);
        $this->status = new Status($provider, $this->organization->firstOrganization);
        $this->dictionary = new Dictionary($provider, $this->organization->firstOrganization);
    }
}