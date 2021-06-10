<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCard\Authorization;


use Lichi\Iiko\CardApiProvider;

class Authorization
{
    public Registration $registration;

    public function __construct(CardApiProvider $apiProvider, string $organizationId){
        $this->registration = new Registration($apiProvider, $organizationId);
    }

}