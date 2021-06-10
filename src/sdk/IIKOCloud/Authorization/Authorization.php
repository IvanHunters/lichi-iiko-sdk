<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCloud\Authorization;


use Lichi\Iiko\ApiProvider;

class Authorization
{
    public Login $login;

    public function __construct(ApiProvider $apiProvider, string $organizationId){
        $this->login = new Login($apiProvider, $organizationId);
    }

}