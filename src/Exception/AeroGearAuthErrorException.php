<?php
/**
 * This file is part of the AeroGearPush package.
 *
 * (c) Napp <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Napp\AeroGearPush\Exception;

/**
 * Class AeroGearAuthErrorException
 * @package Napp\AeroGearPush\Exception
 */
class AeroGearAuthErrorException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code);
    }
}
