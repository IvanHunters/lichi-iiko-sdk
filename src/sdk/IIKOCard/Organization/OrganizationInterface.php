<?php


namespace Lichi\Iiko\Sdk\IIKOCard\Organization;


use Lichi\Iiko\CardApiProvider;

interface OrganizationInterface
{
    public function __construct(CardApiProvider $apiProvider);
    public function getFirst(): string;
}