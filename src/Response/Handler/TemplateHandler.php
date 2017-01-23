<?php
/**
 * This class provides functionality of template rendering
 */

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
     * Handle response
     *
     * @see \Maleficarum\Response\Handler\AbstractHandler::handle()
     *
     * @param string $template
     * @param array $data
     *
     * @return \Maleficarum\Response\Handler\AbstractHandler
     */
    public function handle(string $template = '', array $data = []) : \Maleficarum\Response\Handler\AbstractHandler {
        if (empty($template)) {
            throw new \InvalidArgumentException(sprintf('Invalid template path provided. \%s::handle()', static::class));
        }

        $template = $this->view->getView()->getViewsDir() . $template . '.phtml';

        // initialize response content
        $this->body = $this->view->render($template, $data);

        return $this;
    }

    /**
     * Get response content type
     *
     * @see \Maleficarum\Response\Handler\AbstractHandler::getContentType()
     * @return string
     */
    public function getContentType() : string {
        return 'text/html';
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */
}
