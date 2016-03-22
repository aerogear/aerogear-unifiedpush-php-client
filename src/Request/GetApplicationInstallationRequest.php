<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\AeroGearPush\Request;

/**
 * Class GetApplicationInstallationRequest
 *
 * @package Napp\AeroGearPush\Request
 */
class GetApplicationInstallationRequest extends abstractApplicationRequest
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
     * GetApplicationInstallationRequest constructor.
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
