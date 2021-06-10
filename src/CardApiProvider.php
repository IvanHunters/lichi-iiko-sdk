<?php


namespace Lichi\Iiko;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use RuntimeException;

class CardApiProvider
{
    private Client $client;
    protected string $apiLogin;
    protected string $apiPassword;
    public string $token = "";

    /**
     * ApiProvider constructor.
     * @param Client $client
     * @param string $apiLogin
     * @param string $apiPassword
     */
    public function __construct(Client $client, string $apiLogin, string $apiPassword)
    {
        $this->client = $client;
        $this->apiLogin = $apiLogin;
        $this->apiPassword = $apiPassword;

        $this->token = $this->getToken();
    }

    /**
     * @param string $typeRequest
     * @param string $method
     * @param array $params
     * @param bool $useToken
     * @return mixed
     */
    public function callMethod(string $typeRequest, string $method, array $params = [], bool $useToken = true)
    {
        usleep(380000);

        $authParams = [];
        if($useToken){
            $params['for_query']['access_token'] = $this->token;
        }
        if (mb_strtolower($typeRequest) === 'GET' && isset($params['for_query'])) {
            $method .= '?'.http_build_query($params['for_query']);
        } elseif(isset($params['for_query'])) {
            $method .= '?'.http_build_query($params['for_query']);
            unset($params['for_query']);
        }
        try{
            $response = $this->client->request($typeRequest, $method, $params);
        } catch (GuzzleException $exception){
            $response = $exception->getResponse()->getBody(true);
            throw new RuntimeException(sprintf(
                "API ERROR, message: %s",
                $response,
            ));
        }

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
        if (is_null($response))
            return $content;
        return $response;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        $response =  $this->callMethod(
            "GET",
            "/api/0/auth/access_token?user_id={$this->apiLogin}&user_secret={$this->apiPassword}" ,
            [],
            false
        );
        return str_replace("\"", '', $response);
    }
}