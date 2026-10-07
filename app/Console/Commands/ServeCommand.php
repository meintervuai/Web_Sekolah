<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

class ServeCommand extends BaseServeCommand
{
    /**
     * Get the default port for the web server.
     *
     * @return int
     */
    protected function port()
    {
        $port = $this->input->getOption('port');

        if ($port) {
            return (int) $port;
        }

        $appUrl = config('app.url');
        if ($appUrl && ($parsedPort = parse_url($appUrl, PHP_URL_PORT))) {
            return (int) $parsedPort;
        }

        return 8050;
    }
}
