<?php
/**
 * This file is part of the Napp\AeroGearPush package.
 *
 * (c) NAPP <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\AeroGearPush\Request;

/**
 * Class CreateIosVariantRequest
 *
 * @package Napp\AeroGearPush\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class CreateIosVariantRequest extends abstractApplicationRequest
{
    /**
     * @var
     */
    public $certificate;

    /**
     * @var
     */
    public $passphrase;

    /**
     * @var
     */
    public $production;

    /**
     * CreateIosVariantRequest constructor.
     *
     * @param $pushAppId
     */
    public function __construct($pushAppId)
    {
        if (true == $pushAppId) {
            $this->setPushAppId($pushAppId);
        }

        $this->setEndpoint('applications');
        $this->setMethod('POST');
    }

    /**
     * @param $certificate
     *
     * @return $this
     */
    public function setCertificate($certificate)
    {
        $this->setData('certificate', $certificate);

        return $this;
    }

    /**
     * @param mixed $passphrase
     *
     * @return $this
     */
    public function setPassphrase($passphrase)
    {
        $this->setData('passphrase', $passphrase);

        return $this;
    }

    /**
     * @param mixed $production
     *
     * @return $this
     */
    public function setProduction($production)
    {
        $this->setData('production', $production);

        return $this;
    }
}
