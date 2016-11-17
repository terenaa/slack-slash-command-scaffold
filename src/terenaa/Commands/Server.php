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

namespace terenaa\Commands;


use terenaa\Core\Command\CommandSet;

/**
 * Class Server
 * @package terenaa\Commands
 */
class Server extends CommandSet
{
    public function getMethods()
    {
        return array(
            'help' => array($this, 'help'),
            'load' => array($this, 'load')
        );
    }

    /**
     * Returns the server average load
     *
     * @return array Response text (required) and additional information (optional)
     */
    public function load()
    {
        $loadAvg = sys_getloadavg();
        $load1min = number_format($loadAvg[0], 2, ',', '');

        return array(
            'text' => 'Server load: ' . $load1min,
            'additional' => $load1min . ' (1 min) | ' .
                            number_format($loadAvg[1], 2, ',', '') . ' (5 min) | ' .
                            number_format($loadAvg[2], 2, ',', '') . ' (15 min)'
        );
    }

    /**
     * Returns list of commands in this command set
     *
     * @return array Help command response
     */
    public function help()
    {
        return array(
            'text' => 'help command'
        );
    }
}