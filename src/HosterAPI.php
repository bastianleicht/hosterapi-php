<?php
/*
 * Copyright (c) 2021, Bastian Leicht <mail@bastianleicht.de>
 *
 * PDX-License-Identifier: BSD-2-Clause
 */

namespace HosterAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use HosterAPI\Datacenter\DedicatedServer;
use HosterAPI\Datacenter\VirtualServer;
use HosterAPI\Exception\ParameterException;

class HosterAPI
{
    private $httpClient;
    private $credentials;
    private $apiToken;
    private $sandbox;

    /**
     * HosterAPI constructor.
     *
     * @param string    $token      API Token for all requests
     * @param bool      $sandbox    Enables the Sandbox Mode
     * @param null      $httpClient
     */
    public function __construct(
        string $token,
        bool $sandbox = false,
        $httpClient = null
    ) {
        $this->apiToken = $token;
        $this->sandbox = $sandbox;
        $this->setHttpClient($httpClient);
        $this->setCredentials($token, $sandbox);
    }

    /**
     * @param $httpClient Client|null
     */
    public function setHttpClient(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client([
            'allow_redirects' => false,
            'follow_redirects' => false,
            'timeout' => 120,
        ]);
    }

    public function setCredentials($credentials, $sandbox)
    {
        if (!$credentials instanceof Credentials) {
            $credentials = new Credentials($credentials, $sandbox);
        }

        $this->credentials = $credentials;
    }

    /**
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->apiToken;
    }

    /**
     * @return bool
     */
    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * @return Credentials
     */
    private function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @param string    $actionPath The resource path you want to request, see more at the documentation.
     * @param array     $params     Array filled with request params
     * @param string    $method     HTTP method used in the request
     *
     * @return ResponseInterface
     * @throws GuzzleException
     *
     * @throws ParameterException If the given field in params is not an array
     */
    private function request(string $actionPath, array $params = [], string $method = 'GET'): ResponseInterface
    {
        $url = $this->getCredentials()->getUrl() . $actionPath;

        if (!is_array($params)) {
            throw new ParameterException();
        }

        $params['Authorization'] = 'Bearer ' . $this->apiToken;

        switch ($method) {
            case 'GET':
                return $this->getHttpClient()->get($url, [
                    'verify' => false,
                    'headers'  => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                    'query'  => $params,
                ]);
            case 'POST':
                return $this->getHttpClient()->post($url, [
                    'verify' => false,
                    'headers'  => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                    'form_params'   => $params,
                ]);
            case 'PUT':
                return $this->getHttpClient()->put($url, [
                    'verify' => false,
                    'headers'  => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                    'form_params'   => $params,
                ]);
            case 'DELETE':
                return $this->getHttpClient()->delete($url, [
                    'verify' => false,
                    'headers'  => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                    'form_params'   => $params,
                ]);
            default:
                throw new ParameterException('Wrong HTTP method passed');
        }
    }

    /**
     * @param $response ResponseInterface
     *
     * @return array|string
     */
    private function processRequest(ResponseInterface $response)
    {
        $response = $response->getBody()->__toString();
        $result = json_decode($response);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $result;
        } else {
            return $response;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function get($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params);

        return $this->processRequest($response);
    }

    /**
     * @throws GuzzleException
     */
    public function put($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'PUT');

        return $this->processRequest($response);
    }

    /**
     * @throws GuzzleException
     */
    public function post($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'POST');

        return $this->processRequest($response);
    }

    /**
     * @throws GuzzleException
     */
    public function delete($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'DELETE');

        return $this->processRequest($response);
    }

    /* ======================================================================================================================================== */

    private $jobHandler;
    private $softwareHandler;
    private $dedicatedHandler;
    private $virtualServerHandler;

    /**
     * @return Job
     */
    public function job(): Job
    {
        if(!$this->jobHandler) $this->jobHandler = new Job($this);
        return $this->jobHandler;
    }

    /**
     * @return Software
     */
    public function software(): Software
    {
        if(!$this->softwareHandler) $this->softwareHandler = new Software($this);
        return $this->softwareHandler;
    }

    /**
     * @return DedicatedServer
     */
    public function dedicated(): DedicatedServer
    {
        if(!$this->dedicatedHandler) $this->dedicatedHandler = new DedicatedServer($this);
        return $this->dedicatedHandler;
    }

    /**
     * @return VirtualServer
     */
    public function virtualServer(): VirtualServer
    {
        if(!$this->virtualServerHandler) $this->virtualServerHandler = new VirtualServer($this);
        return $this->virtualServerHandler;
    }

}
