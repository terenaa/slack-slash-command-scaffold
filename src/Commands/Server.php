<?php
/**
 * Example command set containing method for displaying server average load.
 *
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

namespace Commands;


use Core\Command\CommandSet;
use Core\Response\SlackResponse;
use Core\Slack\AttachmentColors;

/**
 * Class Server
 * @package Commands
 */
class Server extends CommandSet
{
    /**
     * Returns the server average load
     *
     * @return SlackResponse Response text (required) and additional information (optional)
     */
    public function loadAction()
    {
        $loadAvg = sys_getloadavg();
        $load = array(
            1 => number_format($loadAvg[0], 2, ',', ''),
            5 => number_format($loadAvg[1], 2, ',', ''),
            15 => number_format($loadAvg[2], 2, ',', '')
        );

        return new SlackResponse('Server load: ' . $load[1], "{$load[1]} (1 min) | {$load[5]} (5 min) | {$load[15]} (15 min)", AttachmentColors::GOOD);
    }

    /**
     * Returns list of commands in this command set
     *
     * @param string $commandName
     * @return SlackResponse Help command response
     */
    public function helpAction($commandName = null)
    {
        $commandsList = array(
            '*Command list for /server:*',
            '',
            '*load* - Shows the server average load'
        );

        return new SlackResponse($commandsList);
    }
}