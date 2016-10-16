<?php

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
     * @var mixed
     */
    protected $content;

    /* ------------------------------------ Abstract methods START ------------------------------------- */
    /**
     * Handle response
     * 
     * @param mixed $data
     * @param array $meta
     * @param bool $success
     * @param string|null $template
     *
     * @return $this
     */
    abstract public function handle($data, array $meta, $success, $template);

    /**
     * Get response body
     * 
     * @return string
     */
    abstract public function getBody();

    /**
     * Get content type
     * 
     * @return string
     */
    abstract public function getContentType();
    /* ------------------------------------ Abstract methods END --------------------------------------- */
}
