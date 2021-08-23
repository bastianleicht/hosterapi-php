<?php
/*
 * Copyright (c) 2021, Bastian Leicht <mail@bastianleicht.de>
 *
 * PDX-License-Identifier: BSD-2-Clause
 */

namespace HosterAPI;

use GuzzleHttp\Exception\GuzzleException;

class Job
{
    private $HosterAPI;

    public function __construct(HosterAPI $HosterAPI)
    {
        $this->HosterAPI = $HosterAPI;
    }

    /**
     * @param int $job_id
     * @return array|string
     * @throws GuzzleException
     */
    public function getJob(int $job_id)
    {
        return $this->HosterAPI->get('job/' . $job_id);
    }

}