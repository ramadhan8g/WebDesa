<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Job_prosess
{
    protected $os;

    public function __construct()
    {
        $this->os = php_uname('s');
    }

    public function kill($pid)
    {
        if (function_exists('posix_kill')) {
            posix_kill($pid, SIGKILL);
        } elseif ($this->os == 'Windows NT') {
            //'F' to Force kill a process
            exec("taskkill /pid {$pid} /F");
        } elseif ($this->os == 'Linux') {
            exec("kill -9 {$pid}");
        }
    }
}
