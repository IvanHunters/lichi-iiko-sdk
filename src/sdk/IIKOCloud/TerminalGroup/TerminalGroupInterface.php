<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\TerminalGroup;


use Lichi\Iiko\ApiProvider;

interface TerminalGroupInterface
{
    public function __construct(ApiProvider $apiProvider, string $organizationId = "");
    public function getTerminalGroups(string $organizationId, bool $includeDisabled = false): array;
}