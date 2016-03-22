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
 * Class CreateAndroidVariantTest
 *
 * @package AeroGearPush\Tests
 */
class CreateAndroidVariantTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     * @throws \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function testCreateAndroidVariant()
    {
        $client = new DummyClient();

        $response = $client->call(
          'POST',
          'https://host.com/rest',
          'applications/6d917118/android',
          [],
          [],
          []
        );

        $response = json_decode($response);

        $this->assertEquals(
          'a69d2e3f-1447-4bfc-b355-42439e2c2ab9',
          $response->id
        );
        $this->assertEquals(
          'a6d35fa9-8ed4-459d-a1f9-c8d0a3c9c34f',
          $response->variantID
        );
        $this->assertEquals('{GOOGLE_KEY}', $response->googleKey);
        $this->assertEquals('android', $response->type);
    }
}
