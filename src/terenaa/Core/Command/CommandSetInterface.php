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
 * Interface CommandSetInterface
 * @package terenaa\Core\Command
 */
interface CommandSetInterface
{
    /**
     * @return array
     */
    public function getMethods();

    /**
     * @return array
     */
    public function help();
}