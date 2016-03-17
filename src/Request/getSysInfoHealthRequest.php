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
 * Class getSysInfoHealthRequest
 *
 * @package Napp\AeroGearPush\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class getSysInfoHealthRequest extends abstractApplicationRequest
{
    /**
     * SysInfoHealthRequest constructor.
     */
    public function __construct()
    {
        $this->setEndpoint('sys/info/health');
        $this->setMethod('GET');
    }
}
