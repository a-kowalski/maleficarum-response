<?php

namespace Maleficarum\Response\Handler;

class RawHandler extends \Maleficarum\Response\Handler\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::handle()
     */
    public function handle($data, array $meta, $success, $template) {
        if (null !== $data || !is_array($data)) {
            throw new \InvalidArgumentException('Invalid template parameters provided. \Maleficarum\Response\Handler\RawHandler::handle()');
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
     * @see \Maleficarum\Response\Handler\AbstractHandler::getContentType()
     */
    public function getContentType() {
        return 'text/html';
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */
}
