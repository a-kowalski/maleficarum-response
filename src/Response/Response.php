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
    public function __construct(\Phalcon\Http\Response $response, \Maleficarum\Response\Handler\AbstractHandler $handler)
    {
        // initialize delegation
        $this->setResponseDelegation($response);
        $this->setHandler($handler);

        // initialize response values
        $this->getResponseDelegation()->setStatusCode(200, \Maleficarum\Response\Status::getMessageForStatus(200));
    }
    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ Response methods START ------------------------------------- */
    /**
     * Render a JSON format response.
     *
     * @param mixed $data
     * @param array $meta
     * @param bool $success
     * @param string|null $template
     *
     * @return \Maleficarum\Response\Response
     */
    public function render($data = [], array $meta = [], $success = true, $template = null)
    {
        $this->getHandler()->handle($data, $meta, $success, $template);

        return $this;
    }

    /**
     * Output this response object. That includes sending out headers (if possible) and outputting response body
     *
     * @return \Maleficarum\Response\Response
     * @throws \InvalidArgumentException
     */
    public function output()
    {
        $handler = $this->getHandler();
        // add typical response headers
        $this->getResponseDelegation()->setHeader('Content-Type', $handler->getContentType());
        // send the response
        $this->getResponseDelegation()->setContent($handler->getBody())->send();

        return $this;
    }

    /** RESPONSE DATA METHODS */

    /**
     * Redirect the request to a new URI
     *
     * @param string $url
     * @param bool $immediate
     *
     * @return \Maleficarum\Response\Response
     * @throws \InvalidArgumentException
     */
    public function redirect($url, $immediate = true)
    {
        if (!is_string($url)) throw new \InvalidArgumentException('Incorrect URL - string expected. \Maleficarum\Response\Http\Response::redirect()');

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
     * @throws \InvalidArgumentException
     * @return \Maleficarum\Response\Response
     */
    public function addHeader($name, $value)
    {
        if (!is_string($name)) throw new \InvalidArgumentException('Incorrect header name - string expected. \Maleficarum\Response\Http\Response::addHeader()');
        if (!is_string($value)) throw new \InvalidArgumentException('Incorrect header value - string expected. \Maleficarum\Response\Http\Response::addHeader()');

        $this->getResponseDelegation()->setHeader($name, $value);

        return $this;
    }

    /**
     * Clear all headers.
     *
     * @return \Maleficarum\Response\Response
     */
    public function clearHeaders()
    {
        $this->getResponseDelegation()->resetHeaders();

        return $this;
    }

    /**
     * Detect if the response has already been sent.
     *
     * @return bool
     */
    public function isSent()
    {
        return $this->getResponseDelegation()->isSent();
    }

    /**
     * This method will set the current status code and a RFC recommended status message for that code. Setting
     * an unsupported HTTP status code will result in an exception.
     *
     * @param Integer $code
     *
     * @throws \InvalidArgumentException
     * @return \Maleficarum\Response\Response
     */
    public function setStatusCode($code)
    {
        $this->getResponseDelegation()->setStatusCode($code, \Maleficarum\Response\Status::getMessageForStatus($code));

        return $this;
    }
    /* ------------------------------------ Response methods END --------------------------------------- */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Set the current response delegation object.
     *
     * @param \Phalcon\Http\Response $response
     *
     * @return \Maleficarum\Response\Response
     */
    private function setResponseDelegation(\Phalcon\Http\Response $response)
    {
        $this->phalconResponse = $response;

        return $this;
    }

    /**
     * Fetch the current response delegation object.
     *
     * @return \Phalcon\Http\Response
     */
    private function getResponseDelegation()
    {
        return $this->phalconResponse;
    }

    /**
     * Get handler
     *
     * @return \Maleficarum\Response\Handler\AbstractHandler
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
    public function setHandler(\Maleficarum\Response\Handler\AbstractHandler $handler) {
        $this->handler = $handler;

        return $this;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
