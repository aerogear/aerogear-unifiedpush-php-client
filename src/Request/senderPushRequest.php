<?php
/**
 * This file is part of the Napp\AeroGearPush package.
 *
 * (c) NAPP <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\AeroGearPush\Request;

/**
 * Class senderPushRequest
 *
 * @package Napp\AeroGearPush\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class senderPushRequest extends abstractApplicationRequest
{
    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $criteria;

    /**
     * @var
     */
    public $config;

    /**
     * senderPushRequest constructor.
     */
    public function __construct()
    {
        $this->setEndpoint('sender');
        $this->setMethod('POST');
    }

    /**
     * @param array $message
     *
     * @return $this
     */
    public function setMessage(array $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param array $criteria
     *
     * @return $this
     */
    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }
}
