<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

namespace Core\Command;


/**
 * Interface CommandSetInterface
 * @package Core\Command
 */
interface CommandSetInterface
{
    /**
     * @param string $commandName
     * @return array
     */
    public function helpAction($commandName = null);
}