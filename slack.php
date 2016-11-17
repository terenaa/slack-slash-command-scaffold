<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

require_once dirname(__FILE__) . '/src/autoload.php';

$request = new \terenaa\Core\Request();

if (SLACK_TOKEN != $request->get('token')) {
    die('Wrong token.');
}

$response = new \terenaa\Core\Response\Response($request);
$response->send();