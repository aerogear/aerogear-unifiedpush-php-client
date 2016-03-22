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
 * Class createApplicationRequest
 *
 * @package Napp\AeroGearPush\Request
 */
class CreateApplicationRequest extends abstractApplicationRequest
{
    /**
     * createApplicationRequest constructor.
     */
    public function __construct()
    {
        $this->setEndpoint('applications');
        $this->setMethod('POST');
    }
}
