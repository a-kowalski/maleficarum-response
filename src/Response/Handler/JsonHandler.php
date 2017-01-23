<?php
/**
 * This class provides functionality of handling JSON response
 */

namespace Maleficarum\Response\Handler;

class JsonHandler extends \Maleficarum\Response\Handler\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ------------------------------ */
    /**
     * Handle JSON response
     *
     * @see \Maleficarum\Response\Handler\AbstractHandler::handle()
     *
     * @param array $data
     * @param array $meta
     * @param bool $success
     *
     * @return \Maleficarum\Response\Handler\AbstractHandler
     */
    public function handle(array $data = [], array $meta = [], bool $success = true) : \Maleficarum\Response\Handler\AbstractHandler {
        // initialize response content
        $meta = array_merge($meta, [
            'status' => $success ? 'success' : 'failure',
            'version' => !is_null($this->getConfig()) ? $this->getConfig()['global']['version'] : null
        ]);

        $this->body = [
            'meta' => $meta,
            'data' => $data
        ];

        return $this;
    }

    /**
     * Get response content type
     *
     * @see \Maleficarum\Response\Handler\AbstractHandler::getContentType()
     * @return string
     */
    public function getContentType() : string {
        return 'application/json';
    }
    /* ------------------------------------ AbstractHandler methods END -------------------------------- */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Get response body
     * 
     * @see \Maleficarum\Response\Handler\AbstractHandler::getBody()
     * @return string
     */
    public function getBody() {
        // add time profiling data if available
        /** @var \Maleficarum\Profiler\Time $timeProfiler */
        $timeProfiler = $this->getProfiler('time');
        if (!is_null($timeProfiler) && isset($this->body['meta']) && $timeProfiler->isComplete()) {
            $this->body['meta']['time_profile'] = $this->getTimeProfile($timeProfiler);
        }

        // add database profiling data if available
        /** @var \Maleficarum\Profiler\Database $databaseProfiler */
        $databaseProfiler = $this->getProfiler('database');
        if (!is_null($databaseProfiler) && isset($this->body['meta'])) {
            $this->body['meta']['database_profile'] = $this->getDatabaseProfile($databaseProfiler);
        }

        return json_encode($this->body);
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */

    /* ------------------------------------ JsonHandler methods START ---------------------------------- */
    /**
     * Get time profile
     *
     * @param \Maleficarum\Profiler\Time $profiler
     *
     * @return array
     */
    private function getTimeProfile(\Maleficarum\Profiler\Time $profiler) : array {
        return [
            'exec_time' => $profiler->getProfile(),
            'req_per_s' => $profiler->getProfile() > 0 ? round(1 / $profiler->getProfile(), 2) : 0,
        ];
    }

    /**
     * Get database profile
     *
     * @param \Maleficarum\Profiler\Database $profiler
     *
     * @return array
     */
    private function getDatabaseProfile(\Maleficarum\Profiler\Database $profiler) : array {
        $count = $exec = 0;
        foreach ($profiler as $key => $profile) {
            $count++;
            $exec += $profile['execution'];
        }

        return [
            'query_count' => $count,
            'overall_query_exec_time' => $exec
        ];
    }
    /* ------------------------------------ JsonHandler methods END ------------------------------------ */
}
