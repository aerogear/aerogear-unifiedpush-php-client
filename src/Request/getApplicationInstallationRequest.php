<?php
/**
 * This file is part of the Napp\AeroGearPush package.
 *
 * (c) NAPP <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\Request;

/**
 * Class getApplicationInstallationRequest
 *
 * @package Napp\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class getApplicationInstallationRequest extends abstractApplicationRequest
{
    /**
     * @var
     */
    public $variantId;

    /**
     * @var
     */
    public $installationId;

    /**
     * getApplicationInstallationRequest constructor.
     */
    public function __construct()
    {
        $this->setEndpoint('applications/VARIANTID/installations');
        $this->setMethod('GET');
    }

    /**
     * @param $variantId
     *
     * @return $this
     */
    public function setVariantId($variantId)
    {
        $this->variantId = $variantId;

        return $this;
    }

    /**
     * @param $installationId
     *
     * @return $this
     */
    public function setInstallationId($installationId)
    {
        $this->installationId = $installationId;

        return $this;
    }
}
