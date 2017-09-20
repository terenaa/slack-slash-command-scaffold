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
 * Class CommandSet
 * @package Command
 */
abstract class CommandSet implements CommandSetInterface
{
    protected function getCommandName()
    {
        return '/' . strtolower(substr(strrchr(get_called_class(), "\\"), 1));
    }
}