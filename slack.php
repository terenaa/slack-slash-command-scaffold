<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

if (file_exists(ROOT . 'vendor/autoload.php')) {
    require_once ROOT . 'vendor/autoload.php';
}

if (file_exists(ROOT . 'config/config.php')) {
    require_once ROOT . 'config/config.php';
}

$request = new \Core\Request();

if (SLACK_TOKEN != $request->get('token')) {
    die('Wrong token.');
}

$response = new \Core\Response\Response($request);
$response->send();