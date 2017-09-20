<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

namespace Core;


/**
 * Class Request
 * @package Core
 */
final class Request
{
    /**
     * @var array $data Request data
     */
    private $data;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->prepareRequest();
    }

    /**
     * Gets request field value
     *
     * @param string $name Name of request field
     * @return mixed Request field
     */
    public function get($name)
    {
        if (is_array($this->data) && array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    /**
     * Gets all request fields values
     *
     * @return array
     */
    public function getAll()
    {
        return $this->data;
    }

    /**
     * Sanitizes request fields values
     */
    protected function prepareRequest()
    {
        $filterRules = array(
            'token' => FILTER_SANITIZE_STRING,
            'team_id' => FILTER_SANITIZE_STRING,
            'team_domain' => FILTER_SANITIZE_STRING,
            'channel_id' => FILTER_SANITIZE_STRING,
            'channel_name' => FILTER_SANITIZE_STRING,
            'user_id' => FILTER_SANITIZE_STRING,
            'user_name' => FILTER_SANITIZE_STRING,
            'command' => FILTER_SANITIZE_STRING,
            'text' => FILTER_SANITIZE_STRING,
            'response_url' => FILTER_SANITIZE_STRING
        );

        $this->data = filter_input_array(INPUT_TYPE, $filterRules);
    }
}