<?php
/**
 * This trait provides functionality common to all classes dependant on the \Maleficarum\Response\Response class.
 */

namespace Maleficarum\Response;

trait Dependant
{
    /**
     * Internal storage for the response object.
     *
     * @var \Maleficarum\Response\Response|null
     */
    protected $response = null;

    /* ------------------------------------ Dependant methods START ------------------------------------ */
    /**
     * Inject a new response.
     *
     * @param \Maleficarum\Response\Response $response
     *
     * @return $this
     */
    public function setResponse(\Maleficarum\Response\Response $response) {
        $this->response = $response;

        return $this;
    }

    /**
     * Fetch the currently assigned response object.
     *
     * @return \Maleficarum\Response\Response|null
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Detach the currently assigned response object.
     *
     * @return $this
     */
    public function detachResponse() {
        $this->response = null;

        return $this;
    }
    /* ------------------------------------ Dependant methods END -------------------------------------- */
}
