<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

namespace terenaa\Core\Command;


/**
 * Class CommandSet
 * @package terenaa\Core\Command
 */
abstract class CommandSet implements CommandSetInterface
{
    /**
     * CommandSet constructor.
     */
    final public function __construct()
    {
        return $this->getMethods();
    }
}