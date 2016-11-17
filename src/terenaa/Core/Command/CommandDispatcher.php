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
 * Class CommandDispatcher
 * @package terenaa\Core\Command
 */
final class CommandDispatcher
{
    static private $modules = array();

    /**
     * Module constructor.
     */
    public function __construct()
    {
        $modules = glob(dirname(__FILE__) . '/../../Commands/*.php');

        array_walk($modules, array($this, 'prepareCommandSet'));
    }

    /**
     * Run command from command set
     *
     * @param string $commandSet Command set name
     * @param string $command Command name
     * @return array Module output containing text response (text)
     *               and optionally additional description (additional)
     */
    public function run($commandSet, $command)
    {
        $commandSetName = ucfirst($commandSet);
        $commandParts = explode(' ', $command);
        $command = $commandParts[0];
        $commandArgs = count($commandParts) > 1 ? array_slice($commandParts, 1) : array();

        if (array_key_exists($commandSetName, self::$modules) && array_key_exists($command, self::$modules[$commandSetName])) {
            $obj = self::$modules[$commandSetName][$command][0];
            $command = self::$modules[$commandSetName][$command][1];

            return $obj->$command($commandArgs);
        }

        return array(
            'text' => "No '/{$commandSet} {$command}' command"
        );
    }

    /**
     * Prepare all commands from command set by their paths
     *
     * @param string $path Command set file path
     */
    protected function prepareCommandSet($path)
    {
        $commandSetName = pathinfo($path, PATHINFO_FILENAME);
        $className = "terenaa\\Commands\\$commandSetName";

        /** @var CommandSet $commandSet */
        $commandSet = new $className();

        if (!is_subclass_of($commandSet, 'terenaa\\Core\\Command\\CommandSet')) {
            return;
        }

        foreach ($commandSet->getMethods() as $commandName => $ref) {
            self::$modules[$commandSetName][$commandName] = $ref;
        }
    }
}