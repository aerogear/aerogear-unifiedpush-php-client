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
 * Class CreateSimplepushVariantTest
 *
 * @package AeroGearPush\Tests
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class CreateSimplepushVariantTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateSimplepushVariant()
    {
        $client = new DummyClient();

        $response = $client->call(
          'POST',
          'https://host.com/rest',
          'applications/6d917118/simplePush',
          [],
          [],
          []
        );

        $response = json_decode($response);

        $this->assertEquals(
          '22debd80-04ab-4213-ac6f-18d6c0c106fe',
          $response->id
        );
        $this->assertEquals(
          '13f663bc-6321-4fc0-b8e1-77429d6c180c',
          $response->variantID
        );
        $this->assertEquals('simplePush', $response->type);
    }
}
