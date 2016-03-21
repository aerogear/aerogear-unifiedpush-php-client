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

use GuzzleHttp\Exception\RequestException;
use Napp\AeroGearPush\Client\CurlClient;

/**
 * Class CurlClientTest
 *
 * @package AeroGearPush\Tests
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class CurlClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \GuzzleHttp\Exception\RequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     * @throws \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     * @throws \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     * @throws \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function testCurlClientException()
    {
        $client = new CurlClient();

        $client->call('', '', '', [], []);
    }
}
