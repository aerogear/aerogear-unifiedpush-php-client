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

use Napp\AeroGearPush\AeroGearPush;
use Napp\AeroGearPush\Request\CreateApplicationRequest;

/**
 * Class AeroGearPushTest
 *
 * @package AeroGearPush\Tests
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class AeroGearPushTest extends \PHPUnit_Framework_TestCase
{
    public function testAeroGearPushClient()
    {
        $client = new AeroGearPush('https://url.com/endpoint', [
            'verifySSL' => true,
            'array' => [
                'key1' => 1,
                'key2' => 2,
            ],
        ]);

        $this->assertEquals('https://url.com/endpoint', $client->serverUrl);
        $this->assertEquals(true, $client->verifySSL);
        $this->assertEquals(1, $client->array['key1']);
    }

    public function testCreateApplicationRequest()
    {
        $request = new CreateApplicationRequest();

        $this->assertEquals('applications', $request->endpoint);
        $this->assertEquals('POST', $request->method);
    }
}