<?php

namespace ebitkov\TodoistSDK;

interface ClientAware
{
    public function setClient(Client $client): self;
}