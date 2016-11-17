<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

namespace terenaa\Core\Response;


/**
 * Class ResponseType
 * @package terenaa\Core\Response
 */
final class ResponseType
{
    const IN_CHANNEL = 'in_channel';
    const EPHEMERAL = 'ephemeral';

    /**
     * ResponseType constructor.
     */
    private function __construct()
    {
    }
}