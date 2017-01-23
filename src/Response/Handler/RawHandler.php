<?php
/**
 * This class provides functionality of handling raw response
 */

namespace Maleficarum\Response\Handler;

class RawHandler extends \Maleficarum\Response\Handler\AbstractHandler
{
    /**
     * Internal storage for response content-type
     *
     * @var string
     */
    private $contentType;

    /* ------------------------------------ Magic methods START ---------------------------------------- */
    /**
     * RawHandler constructor.
     *
     * @param string $contentType
     */
    public function __construct(string $contentType = 'text/html') {
        $this->contentType = $contentType;
    }
    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * Handle response
     *
     * @see \Maleficarum\Response\Handler\AbstractHandler::handle()
     *
     * @param string $data
     *
     * @return \Maleficarum\Response\Handler\AbstractHandler
     */
    public function handle(string $data = '') : \Maleficarum\Response\Handler\AbstractHandler {
        // initialize response content
        $this->body = $data;

        return $this;
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Get contentType
     *
     * @return string
     */
    public function getContentType() : string {
        return $this->contentType;
    }

    /**
     * Set contentType
     *
     * @param string $contentType
     *
     * @return \Maleficarum\Response\Handler\RawHandler
     */
    public function setContentType(string $contentType) : \Maleficarum\Response\Handler\RawHandler {
        $this->contentType = $contentType;

        return $this;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
