<?php
/*
 * Copyright (c) 2021, Bastian Leicht <mail@bastianleicht.de>
 *
 * PDX-License-Identifier: BSD-2-Clause
 */

namespace HosterAPI;

use GuzzleHttp\Exception\GuzzleException;

class Software
{
    private $HosterAPI;

    public function __construct(HosterAPI $HosterAPI)
    {
        $this->HosterAPI = $HosterAPI;
    }

    /**
     * Returns a list of currently available software
     * @return array|string
     * @throws GuzzleException
     */
    public function list()
    {
        return $this->HosterAPI->get('software/list');
    }

    /**
     * Installs the chosen software
     * @param string $server_id_or_ip
     * @param string $package
     * @param string $password
     * @param int $port
     * @return array|string
     * @throws GuzzleException
     */
    public function install(string $server_id_or_ip, string $package, string $password, int $port)
    {
        return $this->HosterAPI->post('software/install', [
            'sid|ip' => $server_id_or_ip,
            'package' => $package,
            'password' => $password,
            'port' => $port,
        ]);
    }

    /**
     * Uninstalls the chosen software
     * @param string $server_id_or_ip
     * @param string $package
     * @param string $password
     * @param int $port
     * @return array|string
     * @throws GuzzleException
     */
    public function uninstall(string $server_id_or_ip, string $package, string $password, int $port)
    {
        return $this->HosterAPI->post('software/uninstall', [
            'sid|ip' => $server_id_or_ip,
            'package' => $package,
            'password' => $password,
            'port' => $port,
        ]);
    }

}