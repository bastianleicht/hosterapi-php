<?php

namespace Venocix\HosterAPI\Datacenter;

use GuzzleHttp\Exception\GuzzleException;
use Venocix\HosterAPI\HosterAPI;

class DedicatedServer
{
    private $HosterAPI;

    public function __construct(HosterAPI $HosterAPI)
    {
        $this->HosterAPI = $HosterAPI;
    }

    /**
     * Returns a list of the current Market
     * @return array|string
     * @throws GuzzleException
     */
    public function market()
    {
        return $this->HosterAPI->get('datacenter/dedicated/market');
    }

    /**
     * Orders a dedicated server
     * @param int $server_id
     * @param string $template
     * @param int $ip_count
     * @param string $hostname
     * @return array|string
     * @throws GuzzleException
     */
    public function order(int $server_id, string $template, int $ip_count, string $hostname)
    {
        return $this->HosterAPI->post('datacenter/dedicated/order', [
            'id' => $server_id,
            'template' => $template,
            'ipCount' => $ip_count,
            'hostname' => $hostname,
        ]);
    }

    /**
     * Returns a list of currently available templates
     * @return array|string
     * @throws GuzzleException
     */
    public function templates()
    {
        return $this->HosterAPI->get('datacenter/dedicated/templates');
    }

    /**
     * Lists your currently owned dedicated servers
     * @return array|string
     * @throws GuzzleException
     */
    public function list()
    {
        return $this->HosterAPI->get('datacenter/dedicated');
    }

    /**
     * Starts a dedicated server
     * @param int $server_id
     * @throws GuzzleException
     */
    public function start(int $server_id)
    {
        $this->HosterAPI->put(`datacenter/dedicated/{$server_id}/start`);
    }

    /**
     * Stops a dedicated server
     * @param int $server_id
     * @throws GuzzleException
     */
    public function stop(int $server_id)
    {
        $this->HosterAPI->put(`datacenter/dedicated/{$server_id}/shutdown`);
    }

    /**
     * Restarts a dedicated server
     * @param int $server_id
     * @throws GuzzleException
     */
    public function restart(int $server_id)
    {
        $this->HosterAPI->put(`datacenter/dedicated/{$server_id}/reboot`);
    }

    /**
     * Reinstall a dedicated server
     * @param int $server_id
     * @param string $template
     * @param string $hostname
     * @return array|string
     * @throws GuzzleException
     */
    public function reinstall(int $server_id, string $template, string $hostname)
    {
        return $this->HosterAPI->put(`datacenter/dedicated/{$server_id}/reinstall`, [
            'template' => $template,
            'hostname' => $hostname,
        ]);
    }

    /**
     * Open noVNC Console
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function console(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/dedicated/{$server_id}/console`);
    }

    /**
     * Gets the current status of the dedicated server
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function status(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/dedicated/{$server_id}/status`);
    }

    /**
     * Gets the configuration of the dedicated server
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function config(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/dedicated/{$server_id}/config`);
    }

    /**
     * Terminates the dedicated server
     * WARNING! This will immediately delete the server and revoke access to it!
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function terminate(int $server_id)
    {
        return $this->HosterAPI->post(`datacenter/dedicated/{$server_id}/terminate`);
    }

}