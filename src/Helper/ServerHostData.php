<?php

namespace App\Helper;

class ServerHostData
{
    private $serverUrl;

    public function __construct($serverUrl)
    {
        $this->serverUrl = $serverUrl;
    }

    public function getServerUrl()
    {
        return $this->serverUrl;
    }
}