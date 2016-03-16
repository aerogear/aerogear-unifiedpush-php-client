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
 * Class deleteApplicationRequest
 *
 * @package Napp\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class deleteApplicationRequest extends abstractApplicationRequest
{
    /**
     * createApplicationRequest constructor.
     */
    public function __construct($pushAppId)
    {
        if (true == $pushAppId) {
            $this->setPushAppId($pushAppId);
        }

        $this->setEndpoint('applications');
        $this->setMethod('DELETE');
    }
}
