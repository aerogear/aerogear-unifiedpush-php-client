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

use Napp\AeroGearPush\AeroGearPush;
use Napp\AeroGearPush\Request\GetMetricsDashboardRequest;
use Napp\AeroGearPush\Request\GetMetricsMessagesRequest;
use Napp\AeroGearPush\Request\GetSysInfoHealthRequest;

/**
 * Class AeroGearPushTest
 *
 * @package AeroGearPush\Tests
 */
class AeroGearPushTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Napp\AeroGearPush\Exception\AeroGearPushException
     */
    public function testServerUrlException()
    {
        new AeroGearPush();
    }

    public function testAeroGearPushClass()
    {
        $serverUrl     = 'http://host.com';
        $masterSecret  = uniqid();
        $applicationId = uniqid();
        $validateSSL   = true;

        $aerogear = new AeroGearPush($serverUrl);

        $aerogear->setApplicationId($applicationId);
        $aerogear->setMasterSecret($masterSecret);
        $aerogear->setValidateSSL($validateSSL);

        $this->assertEquals($serverUrl, $aerogear->serverUrl);
        $this->assertEquals($masterSecret, $aerogear->masterSecret);
        $this->assertEquals($applicationId, $aerogear->applicationId);
        $this->assertTrue($aerogear->verifySSL);
    }

    /**
     * @expectedException  \Napp\AeroGearPush\Exception\AeroGearMissingOAuthTokenException
     */
    public function testSysInfoHealthException()
    {
        $serverUrl = 'http://host.com/';

        $request  = new GetSysInfoHealthRequest();
        $aerogear = new AeroGearPush($serverUrl);
        $aerogear->sysInfoHealth($request);
    }

    public function testSysInfoHealth()
    {
        $serverUrl = 'http://host.com/';
        $aerogear = new AeroGearPush($serverUrl);

        $request  = new GetSysInfoHealthRequest();
        $request->setOAuthToken(uniqid());

        $aerogear->sysInfoHealth($request);
    }

    public function testMetricsDashboard()
    {
        $serverUrl = 'http://host.com/';
        $aerogear = new AeroGearPush($serverUrl);

        $request  = new GetMetricsDashboardRequest();
        $request->setOAuthToken(uniqid());

        $aerogear->metricsDashboard($request);
    }

    public function testMetricsMessages()
    {
        $serverUrl = 'http://host.com/';
        $aerogear = new AeroGearPush($serverUrl);

        $request  = new GetMetricsMessagesRequest(uniqid());
        $request->setOAuthToken(uniqid());

        $aerogear->metricsMessages($request);
    }
}
