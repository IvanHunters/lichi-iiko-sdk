<?php


namespace Lichi\Iiko;

use GuzzleHttp\RequestOptions;
use \Psr\Http\Client\ClientInterface;
use RuntimeException;

class ApiProvider
{
    private ClientInterface $client;
    protected string $apiLogin;
    public string $token = "";

    /**
     * ApiProvider constructor.
     * @param ClientInterface $client
     * @param string $apiLogin
     */
    public function __construct(ClientInterface $client, string $apiLogin)
    {
        $this->client = $client;
        $this->apiLogin = $apiLogin;

        $this->token = $this->getToken();
    }

    /**
     * @param string $typeRequest
     * @param string $method
     * @param array $params
     * @return mixed
     */
    public function callMethod(string $typeRequest, string $method, array $params = [], bool $useToken = true)
    {
        usleep(380000);

        $authParams = [];
        if($useToken){
            $params['headers'] = [
                'Authorization' => "Bearer {$this->token}"
            ];
        }
        $response = $this->client->request($typeRequest, $method, $params);

        if ($response->getStatusCode() != 200) {
            throw new RuntimeException(sprintf(
                "Http status code not 200, got %s status code, message: %s",
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));
        }

        /** @var string $content */
        $content = $response->getBody()->getContents();

        /** @var array $response */
        $response = json_decode($content, true);

        if (isset($response['errorDescription'])) {
            throw new \RuntimeException($response['errorDescription']);
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        $response =  $this->callMethod(
            "POST",
            "/api/1/access_token" ,
            [
                RequestOptions::JSON => [
                    'apiLogin' => $this->apiLogin
                ]
            ],
            false
        );
        return $response['token'];
    }
}