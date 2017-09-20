<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

/**
 * Slack token. Can be obtained from
 * Browse Apps > Custom Integrations > Slash Commands > Edit Configuration page.
 */
define('SLACK_TOKEN', '');

/**
 * Input type defined in Slack Slash Command configuration page (INPUT_GET or INPUT_POST)
 */
define('INPUT_TYPE', INPUT_POST);

/**
 * Environment (dev or prod)
 */
define('ENVIRONMENT', 'prod');

/**
 * Display errors
 */
if ('dev' == ENVIRONMENT) {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
} else {
    error_reporting(~E_ALL);
    ini_set('display_errors', false);
}