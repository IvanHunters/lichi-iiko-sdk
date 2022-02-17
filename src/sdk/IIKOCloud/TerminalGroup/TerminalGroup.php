<?php


namespace Lichi\Iiko\Sdk\IIKOCloud\TerminalGroup;


use GuzzleHttp\RequestOptions;
use http\Exception\RuntimeException;
use Lichi\Iiko\ApiProvider;

class TerminalGroup implements TerminalGroupInterface
{

    private ApiProvider $apiProvider;
    private array $terminalGroups = [];

    public function __construct(ApiProvider $apiProvider, string $organizationId = "")
    {
        $this->apiProvider = $apiProvider;
        if (!empty($organizationId)) {
            $this->terminalGroups = $this->getTerminalGroups($organizationId);
        }
    }

    public function getTerminalGroups(string $organizationId, bool $includeDisabled = false): array
    {
        $response = $this->apiProvider->callMethod('POST', '/api/1/terminal_groups', [
            RequestOptions::JSON => [
                'organizationIds' => [$organizationId],
                'includeDisabled' => $includeDisabled
            ]
        ]);
        $this->terminalGroups = $response['terminalGroups'];
        return $this->terminalGroups;
    }

    public function getGroups(): array
    {
        return $this->terminalGroups;
    }

    public function getFirstTerminalGroup(): string
    {
            if (count($this->terminalGroups) === 0) {
                throw new \RuntimeException("Terminal groups is empty!");
            }
            return $this->terminalGroups[0]['items'][0]['id'];
    }
}