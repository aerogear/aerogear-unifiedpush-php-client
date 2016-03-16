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
 * Class getMetricsDashboardRequest
 *
 * GET dashboard data.
 *
 * @package Napp\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class getMetricsDashboardRequest extends abstractApplicationRequest
{
    /**
     * @var
     */
    public $type;

    /**
     * MetricsDashboardRequest constructor.
     */
    public function __construct()
    {
        $this->setEndpoint('metrics/dashboard');
        $this->setMethod('GET');
    }

    /**
     * Set message dashboard
     * @param $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
