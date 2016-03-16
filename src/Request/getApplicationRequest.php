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
 * Class getApplicationRequest
 *
 * @package Napp\Request
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class getApplicationRequest extends abstractApplicationRequest
{
    /**
     * getApplicationRequest constructor.
     *
     * @param bool $pushAppId
     */
    public function __construct($pushAppId = false)
    {
        if (true == $pushAppId) {
            $this->setPushAppId($pushAppId);
        }

        $this->setEndpoint('applications');
        $this->setMethod('GET');
    }

    /**
     * @param $pageNumber
     *
     * @return $this
     */
    public function setPageNumber($pageNumber)
    {
        $this->setQueryParam('page', $pageNumber);

        return $this;
    }

    /**
     * @param $itemsPerPage
     *
     * @return $this
     */
    public function setPerPage($itemsPerPage)
    {
        $this->setQueryParam('per_page', $itemsPerPage);

        return $this;
    }

    /**
     * @return $this
     */
    public function enableDeviceCount()
    {
        $this->setQueryParam('includeDeviceCount', 'true');

        return $this;
    }

    /**
     * @return $this
     */
    public function enableActivity()
    {
        $this->setQueryParam('includeActivity', 'true');

        return $this;
    }
}
