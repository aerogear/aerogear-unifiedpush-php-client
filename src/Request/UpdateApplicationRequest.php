<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\AeroGearPush\Request;

/**
 * Class UpdateApplicationRequest
 *
 * @package Napp\AeroGearPush\Request
 */
class UpdateApplicationRequest extends abstractApplicationRequest
{
    /**
     * UpdateApplicationRequest constructor.
     *
     * @param $pushAppId
     */
    public function __construct($pushAppId)
    {
        if (true == $pushAppId) {
            $this->setPushAppId($pushAppId);
        }

        $this->setEndpoint('applications');
        $this->setMethod('PUT');
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
}
