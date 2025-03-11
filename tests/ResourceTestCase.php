<?php

namespace Jetimob\ActiveCampaign\Tests;

use Jetimob\ActiveCampaign\Http\Client;
use PHPUnit\Framework\TestCase;

abstract class ResourceTestCase extends TestCase
{
    protected Client $client;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new Client(
            $_ENV['API_URL'],
            $_ENV['API_TOKEN'],
            $_ENV['EVENT_TRACKING_ACTID'],
            $_ENV['EVENT_TRACKING_KEY']
        );
    }

}
