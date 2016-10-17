<?php

namespace Maleficarum\Response\Handler;

class TemplateHandler extends \Maleficarum\Response\Handler\AbstractHandler
{
    /**
     * Internal storage for view engine object
     * 
     * @var \Phalcon\Mvc\View\Engine\Volt
     */
    private $view;

    /* ------------------------------------ Magic methods START ---------------------------------------- */
    /**
     * TemplateHandler constructor.
     *
     * @param \Phalcon\Mvc\View\Engine\Volt $view
     */
    public function __construct(\Phalcon\Mvc\View\Engine\Volt $view) {
        $this->view = $view;
    }
    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::handle()
     */
    public function handle($data, array $meta, $success, $template) {
        if (null !== $data && !is_array($data)) {
            throw new \InvalidArgumentException('Invalid template parameters provided. \Maleficarum\Response\Handler\TemplateHandler::handle()');
        }

        if (empty($template)) {
            throw new \InvalidArgumentException('Invalid template path provided. \Maleficarum\Response\Handler\TemplateHandler::handle()');
        }

        $template = $this->view->getView()->getViewsDir() . $template . '.phtml';

        // initialize response content
        $this->content = $this->view->render($template, $data);

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
