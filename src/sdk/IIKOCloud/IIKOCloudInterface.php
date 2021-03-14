<?php


namespace Lichi\Iiko\Sdk\IIKOCloud;


use Lichi\Iiko\ApiProvider;

interface IIKOCloudInterface
{
    public function __construct(ApiProvider $provider);
}