<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Napp\AeroGearPush\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Napp\AeroGearPush\Exception\AeroGearAuthErrorException;
use Napp\AeroGearPush\Exception\AeroGearBadRequestException;
use Napp\AeroGearPush\Exception\AeroGearNotFoundException;
use Napp\AeroGearPush\Exception\AeroGearPushException;

/**
 * Class CurlClient
 *
 * @package Napp\AeroGearPush\Client
 */
class CurlClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * CurlClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param       $method
     * @param       $url
     * @param       $endpoint
     * @param       $auth
     * @param       $data
     * @param array $options
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     * @throws \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function call($method, $url, $endpoint, $auth, $data, $options = [])
    {
        $queryParams = null;
        $headers = [];

        // Parse query parameters.
        if (!empty($options['queryParam']) && is_array($options['queryParam'])) {
            $endpoint = rtrim($endpoint, '/');
            $endpoint .= '/?'.$queryParams = http_build_query(
                $options['queryParam']
              );
        }

        // Parse the headers array.
        if (!empty($data['headers'])) {
            $headers = $data['headers']['headers'];
            unset($data['headers']);
        }

        // Set Authorization Bearer if a Oauth token is available.
        if (isset($options['OAuthToken'])) {
            $headers['Authorization'] = 'Bearer '.$options['OAuthToken'];
            // If Authorization bearer is avail, disable auth.
            $auth = [];
        }

        // Set datatype, whether it's a file upload or json
        if (isset($data['certificate'])) {
            $dataType = 'multipart';
            foreach ($data as $key => $value) {
                $data[] = [
                  'name'     => $key,
                  'contents' => $value,
                ];
                unset($data[$key]);
            }
        } else {
            $dataType                = 'json';
            $headers['Content-Type'] = 'application/json';
        }

        try {
            $response = $this->client->request(
              $method,
              $url.$endpoint,
              [
                'debug'       => false,
                'http_errors' => true,
                'verify'      => isset($options['verifySSL']) ? $options['verifySSL'] : true,
                $dataType     => $data,
                'auth'        => $auth,
                'headers'     => $headers,
              ]
            );

            return $response->getBody();
        } catch (ClientException $e) {
            switch ($e->getCode()) {
                case 400:
                case 415:
                    throw new AeroGearBadRequestException($e->getMessage(), $e->getCode());
                case 401:
                    throw new AeroGearAuthErrorException($e->getMessage(), $e->getCode());
                case 404:
                    throw new AeroGearNotFoundException($e->getMessage(), $e->getCode());
                case 500:
                    throw new AeroGearPushException($e->getMessage(), $e->getCode());
            }
        }
    }
}
