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

use Napp\AeroGearPush\Exception\AeroGearAuthErrorException;

/**
 * Class GetApplicationRequest
 *
 * @package Napp\AeroGearPush\Request
 */
class GetApplicationRequest extends abstractApplicationRequest
{
    /**
     * GetApplicationRequest constructor.
     *
     * @param bool $pushAppId
     *
     * @throws \Napp\AeroGearPush\Exception\AeroGearAuthErrorException
     */
    public function __construct($pushAppId = false)
    {
        if (false == $pushAppId) {
            throw new AeroGearAuthErrorException();
        }
        
        $this->setPushAppId($pushAppId);

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
