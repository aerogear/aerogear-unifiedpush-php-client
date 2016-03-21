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

use Napp\AeroGearPush\Exception\AeroGearAuthErrorException;
use Napp\AeroGearPush\Exception\AeroGearBadRequestException;
use Napp\AeroGearPush\Exception\AeroGearMissingOAuthTokenException;
use Napp\AeroGearPush\Exception\AeroGearNotFoundException;
use Napp\AeroGearPush\Exception\AeroGearPushException;

/**
 * Class AeroGearExceptionTest
 *
 * @package AeroGearPush\Tests
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class AeroGearExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Napp\AeroGearPush\Exception\AeroGearNotFoundException
     */
    public function testNotFoundException()
    {
        throw new AeroGearNotFoundException();
    }

    /**
     * @expectedException \Napp\AeroGearPush\Exception\AeroGearBadRequestException
     */
    public function testBadRequestException()
    {
        throw new AeroGearBadRequestException();
    }

    /**
     * @expectedException \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function testPushException()
    {
        throw new AeroGearPushException();
    }

    /**
     * @expectedException \Napp\AeroGearPush\Exception\AeroGearMissingOAuthTokenException
     */
    public function testMissingOAuthException()
    {
        throw new AeroGearMissingOAuthTokenException();
    }

    /**
     * @expectedException \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     */
    public function testAuthErrorException()
    {
        throw new AeroGearAuthErrorException();
    }
}
