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


/**
 * Class SlackResponse
 * @package Core\Response
 */
final class SlackResponse
{
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
     * Response constructor.
     *
     * @param mixed $responseText
     * @param mixed $attachmentText
     * @param mixed $attachmentColor Attachment border color; can be AttachmentColors constant or hex value
     */
    public function __construct($responseText, $attachmentText = null, $attachmentColor = null)
    {
        $this->setResponseText($responseText);
        $this->setAttachmentText($attachmentText);
        $this->attachmentColor = $attachmentColor;
    }

    /**
     * @return string
     */
    public function getResponseText()
    {
        return $this->responseText;
    }

    /**
     * @param string $responseText
     */
    public function setResponseText($responseText)
    {
        if (is_array($responseText)) {
            $this->responseText = implode("\n", $responseText);
        } else {
            $this->responseText = $responseText;
        }
    }

    /**
     * @return string
     */
    public function getAttachmentText()
    {
        return $this->attachmentText;
    }

    /**
     * @param string $attachmentText
     */
    public function setAttachmentText($attachmentText)
    {
        if (is_array($attachmentText)) {
            $this->attachmentText = implode("\n", $attachmentText);
        } else {
            $this->attachmentText = $attachmentText;
        }
    }

    /**
     * @return mixed
     */
    public function getAttachmentColor()
    {
        return $this->attachmentColor;
    }

    public function setAttachmentColor($attachmentColor)
    {
        $this->attachmentColor = $attachmentColor;
    }
}