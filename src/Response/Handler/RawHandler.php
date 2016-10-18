<?php

namespace Maleficarum\Response\Handler;

class RawHandler extends \Maleficarum\Response\Handler\AbstractHandler
{
    /**
     * Internal storage for response content-type
     *
     * @var string|null
     */
    private $contentType = null;

    /* ------------------------------------ Magic methods START ---------------------------------------- */
    /**
     * RawHandler constructor.
     *
     * @param null|string $contentType
     */
    public function __construct($contentType = 'text/html') {
        $this->contentType = $contentType;
    }
    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::handle()
     */
    public function handle($data, array $meta, $success, $template) {
        if (!is_string($data)) {
            throw new \InvalidArgumentException('Invalid content provided. \Maleficarum\Response\Handler\RawHandler::handle()');
        }

        // initialize response content
        $this->content = $data;

        return $this;
    }

    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::getBody()
     */
    public function getBody() {
        return $this->content;
    }

    /**
     * Set content type
     *
     * @param string $contentType
     *
     * @return \Maleficarum\Response\Handler\RawHandler
     */
    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::getContentType()
     */
    public function getContentType() {
        return $this->contentType;
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */
}
