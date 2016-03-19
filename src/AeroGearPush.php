<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\AeroGearPush;

use Napp\AeroGearPush\Client\CurlClient;
use Napp\AeroGearPush\Exception\AeroGearMissingOAuthTokenException;
use Napp\AeroGearPush\Exception\AeroGearPushException;
use Napp\AeroGearPush\Request\CreateAndroidVariantRequest;
use Napp\AeroGearPush\Request\CreateIosVariantRequest;
use Napp\AeroGearPush\Request\CreateSimplePushVariantRequest;
use Napp\AeroGearPush\Request\DeleteApplicationRequest;
use Napp\AeroGearPush\Request\GetApplicationInstallationRequest;
use Napp\AeroGearPush\Request\GetApplicationRequest;
use Napp\AeroGearPush\Request\GetMetricsDashboardRequest;
use Napp\AeroGearPush\Request\GetMetricsMessagesRequest;
use Napp\AeroGearPush\Request\GetSysInfoHealthRequest;
use Napp\AeroGearPush\Request\SenderPushRequest;

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
     * @var \Napp\AeroGearPush\Client\CurlClient
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
        if (false == $serverUrl || false == parse_url($serverUrl)) {
            throw new AeroGearPushException('No, or malformed serverUrl available');
        }

        $this->setServerUrl($serverUrl);

        if (0 < count($options)) {
            foreach ($options as $option => $value) {
                $this->$option = $value;
            }
        }

        $this->curlClient = new CurlClient();
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
     * @param \Napp\AeroGearPush\Request\GetSysInfoHealthRequest $request
     *
     * @return string
     * @throws \Napp\AeroGearPush\Exception\AeroGearMissingOAuthTokenException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function sysInfoHealth(GetSysInfoHealthRequest $request)
    {
        if (!isset($request->OAuthToken)) {
            throw new AeroGearMissingOAuthTokenException();
        }
        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint,
          [],
          $request->data,
          [
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }

    /**
     * GET dashboard data.
     *
     * @param \Napp\AeroGearPush\Request\GetMetricsDashboardRequest $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function metricsDashboard(GetMetricsDashboardRequest $request)
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
          [
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }

    /**
     * GET info about submitted push messages for the given Push Application
     *
     * @param \Napp\AeroGearPush\Request\GetMetricsMessagesRequest $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function metricsMessages(GetMetricsMessagesRequest $request)
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
            'OAuthToken' => $request->OAuthToken,
            'queryParam' => isset($request->queryParam) ? $request->queryParam : false,
          ]
        );

        return $response;
    }

    /**
     * @param \Napp\AeroGearPush\Request\CreateSimplePushVariantRequest $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function createSimplePushVariant(CreateSimplePushVariantRequest $request)
    {
        if (null == $request->pushAppId) {
            throw new AeroGearPushException('No pushAppId.');
        }

        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.'/'.$request->pushAppId.'/simplePush',
          [],
          $request->data,
          [
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }

    /**
     * @param \Napp\AeroGearPush\Request\CreateIosVariantRequest $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function createIosVariant(CreateIosVariantRequest $request)
    {
        if (null == $request->pushAppId) {
            throw new AeroGearPushException('No pushAppId.');
        }

        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.'/'.$request->pushAppId.'/ios',
          [],
          $request->data,
          [
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }

    /**
     * @param \Napp\AeroGearPush\Request\CreateAndroidVariantRequest $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function createAndroidVariant(CreateAndroidVariantRequest $request)
    {
        if (null == $request->pushAppId) {
            throw new AeroGearPushException('No pushAppId.');
        }

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
          $request->endpoint.'/'.$request->pushAppId.'/android',
          [],
          $request->data,
          [
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }

    /**
     * @param $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
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
          [
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }

    /**
     * @param \Napp\AeroGearPush\Request\GetApplicationInstallationRequest $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function getApplicationInstallation(GetApplicationInstallationRequest $request)
    {
        if (null == $request->variantId) {
            throw new AeroGearPushException('No variantId.');
        }

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
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }


    /**
     * @param \Napp\AeroGearPush\Request\GetApplicationRequest $request
     *
     * @return mixed
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function getApplication(GetApplicationRequest $request)
    {
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
            'OAuthToken' => $request->OAuthToken,
            'queryParam' => isset($request->queryParam) ? $request->queryParam : false,
          ]
        );

        return $response;
    }

    /**
     * @param \Napp\AeroGearPush\Request\DeleteApplicationRequest $request
     *
     * @return array
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function deleteApplication(DeleteApplicationRequest $request)
    {
        if (null == $request->pushAppId) {
            throw new AeroGearPushException('No pushAppId.');
        }

        if (!empty($request->headers)) {
            $request->data['headers'] = $request->headers;
        }

        $response = $this->curlClient->call(
          $request->method,
          $this->serverUrl,
          $request->endpoint.'/'.$request->pushAppId,
          [],
          $request->data,
          [
            'verifySSL'  => false,
            'OAuthToken' => $request->OAuthToken,
          ]
        );

        return $response;
    }

    /**
     * @param \Napp\AeroGearPush\Request\SenderPushRequest $request
     *
     * @return array
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function senderPush(SenderPushRequest $request)
    {
        if (empty($request->message) || empty($request->criteria)) {
            throw new AeroGearPushException("Required fields 'message' and 'criteria' have to be present.");
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
          [
            'verifySSL' => false,
          ]
        );

        return $response;
    }
}
