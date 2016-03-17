<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp;

use Napp\Client\curlClient;
use Napp\Exception\AeroGearPushException;
use Napp\Request\createAndroidVariantRequest;
use Napp\Request\createIosVariantRequest;
use Napp\Request\createSimplePushVariantRequest;
use Napp\Request\deleteApplicationRequest;
use Napp\Request\getApplicationInstallationRequest;
use Napp\Request\getApplicationRequest;
use Napp\Request\getMetricsDashboardRequest;
use Napp\Request\getMetricsMessagesRequest;
use Napp\Request\getSysInfoHealthRequest;
use Napp\Request\senderPushRequest;

/**
 * Class AeroGearPush
 *
 * @package Napp
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class AeroGearPush
{
    /**
     * @var
     */
    private $applicationId;

    /**
     * @var
     */
    private $masterSecret;

    /**
     * @var
     */
    private $serverUrl;

    /**
     * @var \Napp\Client\curlClient
     */
    private $curlClient;

    /**
     * @var
     */
    private $verifySSL;

    /**
     * AeroGearPush constructor.
     */
    public function __construct($serverUrl, $options = [])
    {
        $this->setServerUrl($serverUrl);

        if (0 < count($options)) {
            foreach ($options as $option => $value) {
                $this->$option = $value;
            }
        }

        $this->curlClient = new curlClient();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @return \Napp\AeroGearPush
     */
    public static function create()
    {
        return new AeroGearPush();
    }

    /**
     * @param $verifySSL
     *
     * @return $this
     */
    public function setValidateSSL($verifySSL)
    {
        $this->verifySSL = $verifySSL;

        return $this;
    }

    /**
     * @param $applicationId
     *
     * @return $this
     */
    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    /**
     * @param $serverUrl
     *
     * @return $this
     */
    public function setServerUrl($serverUrl)
    {
        $this->serverUrl = $serverUrl;

        return $this;
    }

    /**
     * @param $masterSecret
     *
     * @return $this
     */
    public function setMasterSecret($masterSecret)
    {
        $this->masterSecret = $masterSecret;

        return $this;
    }

    /**
     * @param \Napp\Request\getSysInfoHealthRequest $request
     *
     * @return string
     * @throws \Exception
     */
    public function sysInfoHealth(getSysInfoHealthRequest $request)
    {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint,
          [],
          $request->data,
          ['verifySSL' => false]
        );

        if (200 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return $response->getBody()->getContents();
    }

    /**
     * GET dashboard data.
     *
     * @param \Napp\Request\getMetricsDashboardRequest $request
     *
     * @return mixed
     * @throws \Napp\Exception\AeroGearPushException
     */
    public function metricsDashboard(getMetricsDashboardRequest $request)
    {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.(isset($request->type) ? '/'.$request->type : null),
          [],
          $request->data,
          ['verifySSL' => false]
        );

        if (200 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * GET info about submitted push messages for the given Push Application
     *
     * @param \Napp\Request\getMetricsMessagesRequest $request
     *
     * @return mixed
     * @throws \Exception
     * @throws \Napp\Exception\AeroGearPushException
     */
    public function metricsMessages(getMetricsMessagesRequest $request)
    {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.(!empty($request->pushAppId) ? '/'.$request->pushAppId : ''),
          [],
          $request->data,
          [
            'verifySSL'  => false,
            'queryParam' => isset($request->queryParam) ? $request->queryParam : false,
          ]
        );

        if (200 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param \Napp\Request\createSimplePushVariantRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function createSimplePushVariant(
      createSimplePushVariantRequest $request
    ) {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.(!empty($request->pushAppId) ? '/'.$request->pushAppId.'/simplePush' : ''),
          [],
          $request->data,
          ['verifySSL' => false]
        );

        if (204 !== $response->getStatusCode() && 201 !== $response->getStatusCode()
        ) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param \Napp\Request\createIosVariantRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function createIosVariant(createIosVariantRequest $request)
    {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.(!empty($request->pushAppId) ? '/'.$request->pushAppId.'/ios' : ''),
          [],
          $request->data,
          ['verifySSL' => false]
        );

        if (204 !== $response->getStatusCode() && 201 !== $response->getStatusCode()
        ) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param \Napp\Request\createAndroidVariantRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function createAndroidVariant(createAndroidVariantRequest $request)
    {
        // Check for required googleKey field.
        if (!isset($request->data['googleKey'])) {
            throw new AeroGearPushException("Required field 'googleKey' not set.");
        }

        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.(!empty($request->pushAppId) ? '/'.$request->pushAppId.'/android' : ''),
          [],
          $request->data,
          ['verifySSL' => false]
        );

        if (201 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function createApplication($request)
    {
        // Check for required data fields.
        if (!isset($request->pushAppId)) {
            if (!isset($request->data['name'])) {
                throw new AeroGearPushException("Required field 'name' not set.");
            }
        }

        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.(isset($request->pushAppId) ? '/'.$request->pushAppId : null),
          [],
          $request->data,
          ['verifySSL' => false]
        );

        if (204 !== $response->getStatusCode() && 201 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }

    public function getApplicationInstallation(
      getApplicationInstallationRequest $request
    ) {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        // Replace the TOKEN with the valid variantId.
        $request->endpoint = str_replace(
          'VARIANTID',
          $request->variantId,
          $request->endpoint
        );

        // If an installationId is present in url, attach to endpoint.
        if (isset($request->installationId)) {
            $request->endpoint .= '/'.$request->installationId;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint,
          [],
          $request->data,
          [
            'verifySSL' => false,
          ]
        );

        if (200 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param \Napp\Request\getApplicationRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public
    function getApplication(
      getApplicationRequest $request
    ) {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.(isset($request->pushAppId) ? '/'.$request->pushAppId : false),
          [],
          $request->data,
          [
            'verifySSL'  => false,
            'queryParam' => isset($request->queryParam) ? $request->queryParam : false,
          ]
        );

        if (200 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param \Napp\Request\deleteApplicationRequest $request
     *
     * @return array
     * @throws \Napp\Exception\AeroGearPushException
     */
    public function deleteApplication(deleteApplicationRequest $request) {
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.'/'.$request->pushAppId,
          [],
          $request->data,
          ['verifySSL' => false]
        );

        if (204 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return ['Deleted'];
    }

    /**
     * @param \Napp\Request\senderPushRequest $request
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function senderPush(senderPushRequest $request)
    {
        if (empty($request->message) || empty($request->criteria))
        {
            throw new AeroGearPushException("Required fields 'message' and 'critera' have to be present.");
        }

        $data = [
          'message'  => $request->message,
          'criteria' => $request->criteria,
        ];

        $auth = $request->auth;

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint,
          $auth,
          $data,
          ['verifySSL' => false]
        );

        if (202 !== $response->getStatusCode()) {
            throw new AeroGearPushException($response->getContent());
        }

        return ['OK'];
    }
}
