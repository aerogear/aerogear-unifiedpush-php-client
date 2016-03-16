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
 * Class createAndroidVariantRequest
 *
 * @package Napp\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class createAndroidVariantRequest extends abstractApplicationRequest
{
    /**
     * createAndroidVariantRequest constructor.
     *
     * @param $pushAppId
     */
    public function __construct($pushAppId)
    {
        if (true == $pushAppId) {
            $this->setPushAppId($pushAppId);
        }

        $this->setEndpoint('applications');
        $this->setMethod('POST');
    }

    /**
     * @param $googleKey
     *
     * @return $this
     */
    public function setGoogleKey($googleKey)
    {
        $this->setData('googleKey', $googleKey);

        return $this;
    }

    /**
     * @param $projectNumber
     *
     * @return $this
     */
    public function setProjectNumber($projectNumber)
    {
        $this->setData('projectNumber', $projectNumber);

        return $this;
    }
}
