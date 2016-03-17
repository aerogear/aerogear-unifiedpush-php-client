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
 * Class createSimplePushVariantRequest
 *
 * @package Napp\AeroGearPush\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class createSimplePushVariantRequest extends abstractApplicationRequest
{
    /**
     * createSimplePushVariantRequest constructor.
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
}
