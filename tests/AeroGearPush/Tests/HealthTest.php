<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) NAPP <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AeroGearPush\Tests;

use Napp\AeroGearPush\Client\DummyClient;

/**
 * Class HealthTest
 *
 * @package AeroGearPush\Tests
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class HealthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     * @throws \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function testHealth()
    {
        $client = new DummyClient();

        $response = $client->call(
          'GET',
          'https://host.com/rest',
          'sys/info/health',
          [],
          [],
          []
        );

        $response = json_decode($response);

        $this->assertEquals('ok', $response->status);
        $this->assertCount(5, $response->details);
        $this->assertEquals('Everything is ok', $response->summary);
        $this->assertEquals('ok', $response->details[3]->test_status);
        $this->assertEquals('online', $response->details[4]->result);
    }
}

