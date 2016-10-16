<?php

namespace Maleficarum\Response\Handler;

class JsonHandler extends \Maleficarum\Response\Handler\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::handle()
     */
    public function handle($data, array $meta, $success, $template) {
        // initialize response content
        $this->content = array_merge([
            'status' => $success ? 'success' : 'failure',
            'version' => !is_null($this->getConfig()) ? $this->getConfig()['global']['version'] : null
        ], $meta);

        $this->content = [
            'meta' => $this->content,
            'data' => $data
        ];

        return $this;
    }

    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::getBody()
     */
    public function getBody() {
        // add time profiling data if available
        if (!is_null($this->getProfiler('time')) && isset($this->content['meta']) && $this->getProfiler('time')->isComplete()) {
            $this->content['meta']['time_profile'] = [
                'exec_time' => $this->getProfiler('time')->getProfile(),
                'req_per_s' => $this->getProfiler('time')->getProfile() > 0 ? round(1 / $this->getProfiler('time')->getProfile(), 2) : "0",
            ];
        }

        // add database profiling data if available
        if (!is_null($this->getProfiler('database')) && isset($this->content['meta'])) {
            $count = $exec = 0;
            foreach ($this->getProfiler('database') as $key => $profile) {
                $count++;
                $exec += $profile['execution'];
            }

            $this->content['meta']['database_profile'] = [
                'query_count' => $count,
                'overall_query_exec_time' => $exec
            ];
        }

        return json_encode($this->content);
    }

    /**
     * @see \Maleficarum\Response\Handler\AbstractHandler::getContentType()
     */
    public function getContentType() {
        return 'application/json';
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */
}
