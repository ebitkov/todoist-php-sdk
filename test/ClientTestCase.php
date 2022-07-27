<?php

namespace ebitkov\TodoistSDK\Test;

use ebitkov\TodoistSDK\API\Project;
use ebitkov\TodoistSDK\Client;
use PHPUnit\Framework\TestCase;

class ClientTestCase extends TestCase
{
    protected function getClient(): Client
    {
        if (!empty($token = getenv('TODOIST_API_TOKEN'))) {
            return new Client($token);
        } else {
            return $this->createStub(Client::class);
        }
    }
}