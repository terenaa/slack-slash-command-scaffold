<?php
/**
 * This file is part of the Slack Slash Command Scaffold package.
 *
 * @author Krzysztof Janda <terenaa@the-world.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributes with this source code.
 */

namespace Core\Response;


use Core\Command\CommandDispatcher;
use Core\Request;

/**
 * Class Response
 * @package Core\Response
 */
final class Response
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $responseText;

    /**
     * @var string
     */
    private $attachmentText;

    /**
     * @var mixed
     */
    private $attachmentColor;

    /**
     * @var string
     */
    private $responseType = ResponseType::IN_CHANNEL;

    /**
     * Response constructor.
     *
     * @param Request $request Request sent by Slack
     * @throws ResponseException
     */
    public function __construct(Request $request)
    {
        $requestParams = $request->getAll();

        if (empty($requestParams)) {
            throw new ResponseException('Request cannot be empty');
        }

        $this->request = $request;
        $this->runCommand();
    }

    /**
     * Send response to Slack or display on screen
     */
    public function send()
    {
        $curlSettings = $this->getCurlSettings();

        if (!$this->request->get('response_url')) {
            die($this->responseText);
        }

        $curl = curl_init();

        curl_setopt_array($curl, $curlSettings);
        curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if (200 === $httpCode) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        }
    }

    /**
     * Returns response text in JSON format
     *
     * @return string Response text
     */
    protected function getResponseParams()
    {
        $params = array(
            'response_type' => $this->responseType,
            'text' => $this->responseText
        );

        if ($this->attachmentText) {
            $params['attachments'][] = array(
                'text' => $this->attachmentText,
                'color' => $this->attachmentColor
            );
        }

        return json_encode($params);
    }

    /**
     * Returns cUrl settings
     *
     * @return array
     */
    protected function getCurlSettings()
    {
        return array(
            CURLOPT_URL => $this->request->get('response_url'),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->getResponseParams(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            )
        );
    }

    /**
     * Runs command from command dispatcher and sets its result as the response
     */
    protected function runCommand()
    {
        $dispatcher = new CommandDispatcher();
        $commandSet = trim(substr($this->request->get('command'), 1));
        $command = trim($this->request->get('text'));

        $this->setResponse($dispatcher->run($commandSet, $command));
    }

    /**
     * Sets given response as the response
     *
     * @param SlackResponse $response
     */
    protected function setResponse(SlackResponse $response)
    {
        $this->responseText = $response->getResponseText();
        $this->attachmentText = $response->getAttachmentText();
        $this->attachmentColor = $response->getAttachmentColor();
    }

    /**
     * Sets response type
     *
     * @param string $type Response type
     */
    public function setResponseType($type)
    {
        $this->responseType = $type;
    }
}