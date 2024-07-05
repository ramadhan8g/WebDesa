<?php



class Security_header
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();

        $this->ci->load->config('security/headers', true);
    }

    public function handle()
    {
        foreach ($this->ci->config->item('security/headers') as $key => $value) {
            if ($key === 'Strict-Transport-Security' && ! is_https()) {
                continue;
            }

            $this->ci->output->set_header("{$key}: {$value}");
        }
    }
}
