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


use Core\Response\SlackResponse;
use Core\String;

/**
 * Class CommandDispatcher
 * @package Core\Command
 */
final class CommandDispatcher
{
    static private $modules = array();

    /**
     * Module constructor.
     */
    public function __construct()
    {
        $modules = glob(ROOT . 'src/Commands/*.php');

        array_walk($modules, array($this, 'prepareCommandSet'));
    }

    /**
     * Run command from command set
     *
     * @param string $commandSet Command set name
     * @param string $command Command name with its arguments
     * @return SlackResponse Module output containing text response and optionally additional description
     */
    public function run($commandSet, $command)
    {
        $commandSetName = ucfirst($commandSet);
        $commandParts = str_getcsv($command, ' ');
        $command = $commandParts[0];
        $commandArgs = count($commandParts) > 1 ? array_slice($commandParts, 1) : array();

        if (array_key_exists($commandSetName, self::$modules) && array_key_exists($command, self::$modules[$commandSetName])) {
            $obj = new self::$modules[$commandSetName][$command]();
            $action = $command . 'Action';

            return $obj->$action($commandArgs);
        }

        return new SlackResponse("No '/{$commandSet} {$command}' command");
    }

    /**
     * Prepare all commands from command set by their paths
     *
     * @param string $path Command set file path
     */
    protected function prepareCommandSet($path)
    {
        $commandSetName = pathinfo($path, PATHINFO_FILENAME);
        $className = "Commands\\$commandSetName";

        /** @var CommandSet $commandSet */
        $commandSet = new $className();

        if (!is_subclass_of($commandSet, 'Core\\Command\\CommandSet')) {
            return;
        }

        $actions = array_filter(get_class_methods($className), array($this, 'isAction'));

        foreach ($actions as &$action) {
            $actionName = $this->prepareActionName($action);
            self::$modules[$commandSetName][$actionName] = $className;
        }
    }

    /**
     * Prepare action name to be normalized
     *
     * @param string $actionName Action name
     * @return bool|string
     */
    protected function prepareActionName($actionName)
    {
        return substr($actionName, 0, -6);
    }

    /**
     * Verify if given command is public action
     *
     * @param string $commandName Command name
     * @return bool Is command a public action
     */
    protected function isAction($commandName)
    {
        return String::endsWith($commandName, 'Action');
    }
}