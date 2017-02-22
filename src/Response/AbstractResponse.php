<?php
/**
 * This class is a base for all response classes
 */

namespace Maleficarum\Response;

abstract class AbstractResponse
{
    /* ------------------------------------ Abstract methods START ------------------------------------- */
    /**
     * Render response
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    abstract public function render() : \Maleficarum\Response\AbstractResponse;

    /**
     * Output current response object
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    abstract public function output() : \Maleficarum\Response\AbstractResponse;

    /**
     * Set response status code
     *
     * @param int $code
     *
     * @return \Maleficarum\Response\AbstractResponse
     */
    abstract public function setStatusCode(int $code) : \Maleficarum\Response\AbstractResponse;
    /* ------------------------------------ Abstract methods END --------------------------------------- */
}
