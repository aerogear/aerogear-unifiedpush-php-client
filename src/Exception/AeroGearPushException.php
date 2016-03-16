<?php
/**
 * This file is part of the Napp\AeroGearPush package.
 *
 * (c) NAPP <http://napp.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Napp\Exception;

/**
 * Class AeroGearPushException
 *
 * @package Napp\Exception
 * @author  Hasse Ramlev Hansen <hasse@ramlev.dk>
 */
class AeroGearPushException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
