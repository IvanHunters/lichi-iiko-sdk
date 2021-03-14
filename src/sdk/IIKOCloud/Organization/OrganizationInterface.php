<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\Organization;


use Lichi\Iiko\ApiProvider;

interface OrganizationInterface
{
    public function __construct(ApiProvider $apiProvider);
    public function getFirst(): string;
}