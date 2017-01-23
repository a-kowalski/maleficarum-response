<?php
/**
 * This class is a base for all response handlers
 */

namespace Maleficarum\Response\Handler;

abstract class AbstractHandler
{
    /**
     * Use \Maleficarum\Config\Dependant functionality.
     *
     * @trait
     */
    use \Maleficarum\Config\Dependant;

    /**
     * Use \Maleficarum\Profiler\Dependant functionality.
     *
     * @trait
     */
    use \Maleficarum\Profiler\Dependant;

    /**
     * Internal storage for content
     *
     * @var string|null
     */
    protected $body;

    /* ------------------------------------ Abstract methods START ------------------------------------- */
    /**
     * Handle response
     *
     * @return \Maleficarum\Response\Handler\AbstractHandler
     */
    abstract public function handle() : \Maleficarum\Response\Handler\AbstractHandler;

    /**
     * Get response content type
     *
     * @return string
     */
    abstract public function getContentType() : string;
    /* ------------------------------------ Abstract methods END --------------------------------------- */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Get response body
     *
     * @return string|null
     */
    public function getBody() {
        return $this->body;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
