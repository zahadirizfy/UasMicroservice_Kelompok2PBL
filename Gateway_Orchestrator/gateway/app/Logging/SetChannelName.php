<?php

namespace App\Logging;

use Monolog\Logger;

class SetChannelName
{
    /**
     * Set a fixed logger name so JsonFormatter shows the desired channel.
     *
     * @param  \Monolog\Logger  $logger
     * @return void
     */
    public function __invoke(Logger $logger)
    {
        // Force the underlying Monolog logger name to 'gateway'
        $logger->setName('gateway');
    }
}
