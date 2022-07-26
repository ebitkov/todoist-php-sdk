<?php

namespace ebitkov\TodoistSDK;

trait ClientTrait
{
    private Client $client;


    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }
}