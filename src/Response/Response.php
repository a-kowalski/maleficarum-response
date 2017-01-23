<?php
/**
 * This class provides the response capabilities that include:
 *  * setting headers
 *  * generating output
 *  * setting a HTTP response code and status message
 */

namespace Maleficarum\Response;

class Response
{
    /**
     * Internal storage for the delegation object.
     *
     * @var \Phalcon\Http\Response|null
     */
    private $phalconResponse = null;

    /**
     * Internal storage for response handler object
     *
     * @var \Maleficarum\Response\Handler\AbstractHandler|null
     */
    private $handler = null;

    /* ------------------------------------ Magic methods START ---------------------------------------- */
    /**
     * Initialize a new instance of the response object.
     *
     * @param \Phalcon\Http\Response $response
     * @param \Maleficarum\Response\Handler\AbstractHandler $handler
     */
    public function __construct(\Phalcon\Http\Response $response, \Maleficarum\Response\Handler\AbstractHandler $handler) {
        // initialize delegation
        $this->setResponseDelegation($response);
        $this->setHandler($handler);

        // set default status code and message
        $this->setStatusCode(\Maleficarum\Response\Status::STATUS_CODE_200);
    }
    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ Response methods START ------------------------------------- */
    /**
     * Render a JSON format response.
     * 
     * @param array $data
     * @param array $meta
     * @param bool $success
     *
     * @return \Maleficarum\Response\Response
     * @throws \LogicException
     */
    public function render(array $data = [], array $meta = [], bool $success = true) : \Maleficarum\Response\Response {
        /** @var \Maleficarum\Response\Handler\JsonHandler $handler */
        $handler = $this->getHandler();

        if (!$handler instanceof \Maleficarum\Response\Handler\JsonHandler) {
            throw new \LogicException(sprintf('Cannot render JSON data without appropriate handler. \%s::render()', static::class));
        }

        $handler->handle($data, $meta, $success);

        return $this;
    }

    /**
     * Render RAW data
     * 
     * @param string $data
     *
     * @return \Maleficarum\Response\Response
     * @throws \LogicException
     */
    public function renderRaw(string $data) : \Maleficarum\Response\Response {
        /** @var \Maleficarum\Response\Handler\RawHandler $handler */
        $handler = $this->getHandler();

        if (!$handler instanceof \Maleficarum\Response\Handler\RawHandler) {
            throw new \LogicException(sprintf('Cannot render RAW data without appropriate handler. \%s::renderRaw()', static::class));
        }

        $handler->handle($data);

        return $this;
    }

    /**
     * Render template
     * 
     * @param string $template
     * @param array $data
     *
     * @return \Maleficarum\Response\Response
     * @throws \LogicException
     */
    public function renderTemplate(string $template, array $data = []) : \Maleficarum\Response\Response {
        /** @var \Maleficarum\Response\Handler\TemplateHandler $handler */
        $handler = $this->getHandler();

        if (!$handler instanceof \Maleficarum\Response\Handler\TemplateHandler) {
            throw new \LogicException(sprintf('Cannot render template without appropriate handler. \%s::renderTemplate()', static::class));
        }

        $handler->handle($template, $data);

        return $this;
    }

    /**
     * Output this response object. That includes sending out headers (if possible) and outputting response body
     *
     * @return \Maleficarum\Response\Response
     */
    public function output() : \Maleficarum\Response\Response {
        $handler = $this->getHandler();
        // add typical response headers
        $this->getResponseDelegation()->setHeader('Content-Type', $handler->getContentType());
        // send the response
        $this->getResponseDelegation()->setContent($handler->getBody())->send();

        return $this;
    }

    /**
     * Redirect the request to a new URI
     *
     * @param string $url
     * @param bool $immediate
     *
     * @return \Maleficarum\Response\Response
     */
    public function redirect(string $url, bool $immediate = true) : \Maleficarum\Response\Response {
        // send redirect header to the response object
        $this->getResponseDelegation()->redirect($url);

        // stop execution and redirect immediately
        if ($immediate) {
            $this->getResponseDelegation()->send();
            exit;
        }

        return $this;
    }

    /**
     * Add a new header.
     *
     * @param string $name
     * @param string $value
     *
     * @return \Maleficarum\Response\Response
     */
    public function addHeader(string $name, string $value) : \Maleficarum\Response\Response {
        $this->getResponseDelegation()->setHeader($name, $value);

        return $this;
    }

    /**
     * Clear all headers.
     *
     * @return \Maleficarum\Response\Response
     */
    public function clearHeaders() : \Maleficarum\Response\Response {
        $this->getResponseDelegation()->resetHeaders();

        return $this;
    }

    /**
     * Detect if the response has already been sent.
     *
     * @return bool
     */
    public function isSent() : bool {
        return $this->getResponseDelegation()->isSent();
    }

    /**
     * This method will set the current status code and a RFC recommended status message for that code. Setting
     * an unsupported HTTP status code will result in an exception.
     *
     * @param int $code
     *
     * @return \Maleficarum\Response\Response
     */
    public function setStatusCode(int $code) : \Maleficarum\Response\Response {
        $message = \Maleficarum\Response\Status::getMessageForStatus($code);

        $this->getResponseDelegation()->setStatusCode($code, $message);

        return $this;
    }
    /* ------------------------------------ Response methods END --------------------------------------- */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Get handler
     *
     * @return \Maleficarum\Response\Handler\AbstractHandler|null
     */
    public function getHandler() {
        return $this->handler;
    }

    /**
     * Set handler
     *
     * @param \Maleficarum\Response\Handler\AbstractHandler $handler
     *
     * @return \Maleficarum\Response\Response
     */
    public function setHandler(\Maleficarum\Response\Handler\AbstractHandler $handler) : \Maleficarum\Response\Response {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Set the current response delegation object.
     *
     * @param \Phalcon\Http\Response $response
     *
     * @return \Maleficarum\Response\Response
     */
    private function setResponseDelegation(\Phalcon\Http\Response $response) : \Maleficarum\Response\Response {
        $this->phalconResponse = $response;

        return $this;
    }

    /**
     * Fetch the current response delegation object.
     *
     * @return \Phalcon\Http\Response|null
     */
    private function getResponseDelegation() {
        return $this->phalconResponse;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
