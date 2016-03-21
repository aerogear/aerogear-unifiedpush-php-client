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
use Napp\AeroGearPush\Request\CreateAndroidVariantRequest;
use Napp\AeroGearPush\Request\CreateApplicationRequest;
use Napp\AeroGearPush\Request\CreateIosVariantRequest;
use Napp\AeroGearPush\Request\CreateSimplePushVariantRequest;
use Napp\AeroGearPush\Request\DeleteApplicationRequest;
use Napp\AeroGearPush\Request\GetApplicationInstallationRequest;
use Napp\AeroGearPush\Request\GetApplicationRequest;
use Napp\AeroGearPush\Request\GetMetricsDashboardRequest;
use Napp\AeroGearPush\Request\GetMetricsMessagesRequest;
use Napp\AeroGearPush\Request\GetSysInfoHealthRequest;
use Napp\AeroGearPush\Request\SenderPushRequest;
use Napp\AeroGearPush\Request\UpdateApplicationRequest;

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
        $client = new AeroGearPush(
          'https://url.com/endpoint', [
            'verifySSL' => true,
          ]
        );

        $this->assertEquals('https://url.com/endpoint', $client->serverUrl);
        $this->assertEquals(true, $client->verifySSL);
        $this->assertInstanceOf(
          'Napp\AeroGearPush\Client\CurlClient',
          $client->curlClient
        );
    }

    public function testCreateApplicationRequest()
    {
        $request = new CreateApplicationRequest();

        $this->assertEquals('applications', $request->endpoint);
        $this->assertEquals('POST', $request->method);
    }

    public function testCreateAndroidApplicationRequest()
    {
        $pushApplicationID = uniqid();
        $request           = new CreateAndroidVariantRequest(
          $pushApplicationID
        );

        $this->assertEquals($pushApplicationID, $request->pushAppId);
        $this->assertEquals('POST', $request->method);

        $request->setGoogleKey('{GOOGLE_KEY}');
        $this->assertEquals('{GOOGLE_KEY}', $request->data['googleKey']);
        $request->setProjectNumber('123');
        $this->assertEquals('123', $request->data['projectNumber']);

    }

    public function testCreateIosApplicationRequest()
    {
        $pushApplicationID = uniqid();
        $request           = new CreateIosVariantRequest($pushApplicationID);

        $this->assertEquals($pushApplicationID, $request->pushAppId);
        $this->assertEquals('POST', $request->method);

        $this->assertTrue(empty($request->data['developer']));
        $request->setDeveloper('Me Myself');
        $this->assertEquals('Me Myself', $request->data['developer']);

        $pass = uniqid();
        $request->setPassphrase($pass);
        $this->assertEquals($pass, $request->data['passphrase']);

        $certificate = uniqid();
        $request->setCertificate($certificate);
        $this->assertEquals($certificate, $request->data['certificate']);

        $this->assertTrue(empty($request->data['production']));
        $request->setProduction(true);
        $this->assertTrue($request->data['production']);
    }

    public function testCreateSimplePushApplicationRequest()
    {
        $pushApplicationID = uniqid();
        $request           = new CreateSimplePushVariantRequest(
          $pushApplicationID
        );

        $this->assertEquals($pushApplicationID, $request->pushAppId);
        $this->assertEquals('POST', $request->method);
    }

    public function testDeleteApplicationRequest()
    {
        $pushApplicationID = uniqid();
        $request           = new DeleteApplicationRequest($pushApplicationID);

        $this->assertEquals($pushApplicationID, $request->pushAppId);
        $this->assertEquals('DELETE', $request->method);
    }

    public function testUpdateApplicationRequest()
    {
        $pushApplicationID = uniqid();
        $request           = new UpdateApplicationRequest($pushApplicationID);
        $this->assertEquals($pushApplicationID, $request->pushAppId);
        $this->assertEquals('PUT', $request->method);

        $this->assertEmpty($request->data);

        $request->setName('New application name');
        $this->assertArrayHasKey('name', $request->data);
        $this->assertEquals('New application name', $request->data['name']);

        $this->assertArrayNotHasKey('description', $request->data);
        $request->setDescription('A description');
        $this->assertEquals('A description', $request->data['description']);
    }

    public function testSenderPushRequest()
    {
        $request = new SenderPushRequest();
        $this->assertEquals('POST', $request->method);

        $pushAppId = uniqid();
        $masterSecret = uniqid();

        $request->setAuth($pushAppId, $masterSecret);
        $this->assertCount(2, $request->auth);
        $this->assertEquals($pushAppId, $request->auth[0]);
        $this->assertEquals($masterSecret, $request->auth[1]);

        $this->assertNull($request->message);
        $message = uniqid();
        $request->setMessage([$message]);
        $this->assertEquals($message, $request->message[0]);

        $criteria = [
          'alias' => ['me', 'myself', 'i'],
        ];
        $this->assertNull($request->criteria);
        $request->setCriteria($criteria);
        $this->assertArrayHasKey('alias', $request->criteria);

        $config = [
          'ttl' => 80,
        ];

        $this->assertNull($request->config);
        $request->setConfig($config);
        $this->assertArrayHasKey('ttl', $request->config);
        $this->assertEquals(80, $request->config['ttl']);
    }

    public function testGetSysInfoHealthRequest()
    {
        $request = new GetSysInfoHealthRequest();

        $bearer = uniqid();
        $request->setHeader('Authorization', 'Bearer '.$bearer);
        $this->assertEquals(
          'Bearer '.$bearer,
          $request->headers['headers']['Authorization']
        );

        $this->assertTrue(empty($request->OAuthToken));
        $oAuthToken = uniqid();
        $request->setOAuthToken($oAuthToken);
        $this->assertEquals($oAuthToken, $request->OAuthToken);

        $this->assertEquals('sys/info/health', $request->endpoint);
        $this->assertEquals('GET', $request->method);
    }

    public function testGetMetricsDashBoardRequest()
    {
        $request = new GetMetricsDashboardRequest();

        $this->assertEquals('metrics/dashboard', $request->endpoint);
        $this->assertEquals('GET', $request->method);

        $this->assertNull($request->type);
        $request->setType('active');
        $this->assertEquals('active', $request->type);

        $request->setType('warnings');
        $this->assertEquals('warnings', $request->type);
    }

    /**
     * @expectedException \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     */
    public function testGetApplicationNoPushAppIdRequest()
    {
        new GetApplicationRequest();
    }

    public function testGetApplicationRequest()
    {
        $pushAppID = uniqid();
        $request = new GetApplicationRequest($pushAppID);

        $this->assertEquals($pushAppID, $request->pushAppId);
        $request->setPageNumber(8);
        $request->setPerPage(10);
        $request->enableActivity();
        $request->enableDeviceCount();

        $this->assertEquals(8, $request->queryParam['page']);
        $this->assertEquals(10, $request->queryParam['per_page']);
        $this->assertEquals('true', $request->queryParam['includeDeviceCount']);
        $this->assertEquals('true', $request->queryParam['includeActivity']);

    }

    public function testGetMetricsMessagesRequest()
    {
        $pushAppId = uniqid();

        $request = new GetMetricsMessagesRequest($pushAppId);

        $this->assertEquals('metrics/messages/application', $request->endpoint);
        $this->assertEquals('GET', $request->method);

        $request->setPageNumber(8);
        $request->setPerPage(10);
        $request->setSort('ASC');
        $request->setSearch('android');

        $this->assertEquals(8, $request->queryParam['page']);
        $this->assertEquals(10, $request->queryParam['per_page']);
        $this->assertEquals('ASC', $request->queryParam['sort']);
        $this->assertEquals('android', $request->queryParam['search']);
    }

    public function testGetApplicationInstallationRequest()
    {
        $request = new GetApplicationInstallationRequest();

        $this->assertEquals('applications/VARIANTID/installations', $request->endpoint);
        $this->assertEquals('GET', $request->method);

        $variantId = uniqid();
        $request->setVariantId($variantId);
        $this->assertEquals($variantId, $request->variantId);

        $installationId = uniqid();
        $request->setInstallationId($installationId);
        $this->assertEquals($installationId, $request->installationId);
    }
}
