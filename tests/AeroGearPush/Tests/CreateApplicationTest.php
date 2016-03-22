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
 * Class CreateApplicationTest
 *
 * @package AeroGearPush\Tests
 */
class CreateApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     * @throws \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function testCreateApplication()
    {
        $client = new DummyClient();

        $response = $client->call(
          'POST',
          'https://host.com/rest',
          'applications',
          [],
          [],
          []
        );

        $response = json_decode($response);

        $this->assertEquals(
          '3aad1e92-3255-461b-8129-854025a5e7ab',
          $response->id
        );
        $this->assertEquals(
          'dc5df3f3-2609-4547-9cc5-a844fc3b09e3',
          $response->pushApplicationID
        );
        $this->assertEmpty($response->variants);
    }
}
