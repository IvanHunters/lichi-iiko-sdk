<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCard;


use Lichi\Iiko\CardApiProvider;
use Lichi\Iiko\Sdk\IIKOCard\Authorization\Registration;
use Lichi\Iiko\Sdk\IIKOCard\Organization\Organization;

class IIKOCard
{
    /**
     * @var Registration
     */
    public Registration $registration;
    /**
     * @var Organization
     */
    private Organization $organization;

    public function __construct(CardApiProvider $provider)
    {
        $this->organization = new Organization($provider);
        $this->registration = new Registration($provider, $this->organization->firstOrganization);
    }

}