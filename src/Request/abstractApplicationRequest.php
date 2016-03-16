<?php
/**
 * This file is part of the Napp\AeroGearPush package.
 *
 * (c) NAPP <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\Request;

/**
 * Class abstractApplicationRequest
 *
 * @package Napp\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class abstractApplicationRequest
{
    /**
     * @var
     */
    public $endpoint;

    /**
     * @var
     */
    public $pushAppId;

    /**
     * @var
     */
    public $bearer;

    /**
     * @var
     */
    public $headers;

    /**
     * @var
     */
    public $data;

    /**
     * @var
     */
    public $auth;

    /**
     * @var
     */
    public $url;

    /**
     * @var
     */
    public $method;

    /**
     * @var
     */
    public $queryParam;

    /**
     * @param $endpoint
     *
     * @return $this
     */
    protected function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    protected function setMethod($method = 'GET')
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param $user
     * @param $pass
     *
     * @return $this
     */
    public function setAuth($user, $pass)
    {
        $this->auth = [
          $user,
          $pass,
        ];

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setHeader($key, $value)
    {
        $this->headers['headers'][$key] = $value;

        return $this;
    }

    /**
     * @param string $contentType
     *
     * @return $this
     */
    public function setContentType($contentType = 'application/json')
    {
        $this->setHeader('Content-Type', $contentType);

        return $this;
    }

    /**
     * @param $bearer
     *
     * @return $this
     */
    public function setBearer($bearer)
    {
        $this->setHeader('Authorization', 'Bearer '.$bearer);

        return $this;
    }

    /**
     * @param $developer
     *
     * @return $this
     */
    public function setDeveloper($developer)
    {
        $this->setData('developer', $developer);

        return $this;

      }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->setData('name', $name);

        return $this;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->setData('description', $description);

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     *
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setQueryParam($key, $value)
    {
        $this->queryParam[$key] = $value;

        return $this;
    }

    /**
     * @param $pushAppId
     *
     * @return $this
     */
    public function setPushAppId($pushAppId)
    {
        $this->pushAppId = $pushAppId;

        return $this;
    }
}
