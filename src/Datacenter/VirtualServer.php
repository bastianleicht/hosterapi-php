<?php

namespace Venocix\HosterAPI\Datacenter;

use GuzzleHttp\Exception\GuzzleException;
use Venocix\HosterAPI\HosterAPI;

class VirtualServer
{
    private $HosterAPI;

    public function __construct(HosterAPI $HosterAPI)
    {
        $this->HosterAPI = $HosterAPI;
    }

    /**
     * Get the status of a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function status(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/server/{$server_id}/status`);
    }

    /**
     * Gets the configuration of a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function config(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/server/{$server_id}/config`);
    }

    /**
     * Gets the incidents of a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function incidents(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/server/{$server_id}/incidents`);
    }

    /**
     * Returns the noVNC Console URL
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function console(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/server/{$server_id}/console`);
    }

    /**
     * Deletes the VM
     * @param int $server_id
     * @param bool $force       To delete the VM even if it is running!
     * @return array|string
     * @throws GuzzleException
     */
    public function delete(int $server_id, bool $force = false)
    {
        return $this->HosterAPI->post(`datacenter/server/{$server_id}/delete`, [
            'force' => $force,
        ]);
    }

    /**
     * Set the VM's RDNS
     * @param int $server_id
     * @param string $server_ip
     * @param string $hostname
     * @return array|string
     * @throws GuzzleException
     */
    public function rdns(int $server_id, string $server_ip, string $hostname)
    {
        return $this->HosterAPI->post(`datacenter/server/{$server_id}/rdns`, [
            'ip' => $server_ip,
            'hostname' => $hostname,
        ]);
    }

    /**
     * Up/Downgrades a VM
     * Note: Downgrading disk size is not allowed due to possible data loss!
     * @param int $server_id
     * @param int $cores
     * @param int $memory
     * @param string $disk
     * @param int $ip_addresses
     * @return array|string
     * @throws GuzzleException
     */
    public function change(int $server_id, int $cores, int $memory, string $disk, int $ip_addresses)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/change`, [
            'cpuCores' => $cores,
            'mem' => $memory,
            'disk' => $disk,
            'ipCount' => $ip_addresses,
        ]);
    }

    /**
     * Starts a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function start(int $server_id)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/start`);
    }

    /**
     * Gracefully stops a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function stop(int $server_id)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/shutdown`);
    }

    /**
     * Forcefully stops a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function forceStop(int $server_id)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/stop`);
    }

    /**
     * Gracefully restarts a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function reboot(int $server_id)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/reboot`);
    }

    /**
     * Forcefully restarts a VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function forceReboot(int $server_id)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/reboot/force`);
    }

    /**
     * Reinstall a VM with the given template
     * @param int $server_id
     * @param string $template
     * @return array|string
     * @throws GuzzleException
     */
    public function reinstall(int $server_id, string $template)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/reinstall`, [
            'template' => $template,
        ]);
    }

    /**
     * Resets the VM's root password
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function resetPassword(int $server_id)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/password/reset`);
    }

    /**
     * Lists the VM's backups
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function backupList(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/server/{$server_id}/backups/list`);
    }

    /**
     * Returns the backup status
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function backupStatus(int $server_id)
    {
        return $this->HosterAPI->get(`datacenter/server/{$server_id}/backups/status`);
    }

    /**
     * Creates a backup of the VM
     * @param int $server_id
     * @return array|string
     * @throws GuzzleException
     */
    public function createBackup(int $server_id)
    {
        return $this->HosterAPI->put(`datacenter/server/{$server_id}/backups/create`);
    }

    /**
     * Restores the VM to the given Backup
     * @param int $server_id
     * @param int $backup
     * @return array|string
     * @throws GuzzleException
     */
    public function restore(int $server_id, int $backup)
    {
        return $this->HosterAPI->post(`datacenter/server/{$server_id}/backups/restore`, [
            'backup' => $backup,
        ]);
    }

    /**
     * Creates a VM with the given Parameters
     * @param string $template
     * @param int $cores
     * @param int $memory
     * @param string $disk
     * @param int $ip_addresses
     * @return array|string
     * @throws GuzzleException
     */
    public function create(string $template, int $cores, int $memory, string $disk, int $ip_addresses)
    {
        return $this->HosterAPI->post('datacenter/server', [
            'template' => $template,
            'cupCores' => $cores,
            'mem' => $memory,
            'disk' => $disk,
            'ipCount' => $ip_addresses,
        ]);
    }

    /**
     * Lists your currently owned VM's
     * @return array|string
     * @throws GuzzleException
     */
    public function list()
    {
        return $this->HosterAPI->get('datacenter/server');
    }

    /**
     * Returns a list of currently available templates
     * @return array|string
     * @throws GuzzleException
     */
    public function templates()
    {
        return $this->HosterAPI->get('datacenter/templates');
    }

}