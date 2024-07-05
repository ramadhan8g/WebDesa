<?php



class Security_trusted_host
{
    /**
     * List of all loaded config values
     *
     * @var array
     */
    public $config = [];

    public function __construct()
    {
        $this->config = &get_config();
    }

    public function handle()
    {
        if (! isset($_SERVER['HTTP_HOST']) || empty($this->config['trusted_hosts'])) {
            return;
        }

        $isValidHost = preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $_SERVER['HTTP_HOST']);

        if (! $isValidHost) {
            log_message('error', sprintf('Untrusted Host "%s".', htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8')));
            show_error(null, 400);
        }

        $trustedHosts = $this->config['trusted_hosts'] ?? [];

        foreach ($trustedHosts as $trustedHost) {
            $parsedUrl       = parse_url(trim($trustedHost));
            $realTrustedHost = trim($parsedUrl['host'] ?? '');

            if ($realTrustedHost && preg_match('/^((.*?)\\.)?' . preg_quote($realTrustedHost) . '$/i', $_SERVER['HTTP_HOST'])) {
                return;
            }
        }

        log_message('error', sprintf('Untrusted Host "%s".', htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8')));
        show_error(null, 400);
    }
}
