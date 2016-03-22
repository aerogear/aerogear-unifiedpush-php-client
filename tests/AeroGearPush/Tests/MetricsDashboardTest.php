<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AeroGearPush\Tests;

use Napp\AeroGearPush\Client\DummyClient;

/**
 * Class MetricsDashboardTest
 *
 * @package AeroGearPush\Tests
 */
class MetricsDashboardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     * @throws \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function testMetricsDashboard()
    {
        $client = new DummyClient();

        $response = $client->call(
          'GET',
          'https://host.com/rest',
          'metrics/dashboard',
          [],
          [],
          []
        );

        $response = json_decode($response);

        $this->assertEquals(4, $response->applications);
        $this->assertEquals(3, $response->devices);
        $this->assertEquals(2, $response->messages);
    }
}
