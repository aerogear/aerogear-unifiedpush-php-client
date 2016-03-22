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
 * Class GetMetricsDashboardRequest
 *
 * GET dashboard data.
 *
 * @package Napp\AeroGearPush\Request
 */
class GetMetricsDashboardRequest extends abstractApplicationRequest
{
    /**
     * @var
     */
    public $type;

    /**
     * GetMetricsDashboardRequest constructor.
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
