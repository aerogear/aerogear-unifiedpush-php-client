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
 * Class SysInfoHealthRequest
 *
 * @package Napp\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class SysInfoHealthRequest extends abstractApplicationRequest
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
