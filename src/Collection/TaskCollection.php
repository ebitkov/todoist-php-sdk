<?php

namespace ebitkov\TodoistSDK\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class TaskCollection extends ArrayCollection implements SerializedCollection
{
    /**
     * @Serializer\Type("array<ebitkov\TodoistSDK\API\Task>")
     * @Serializer\Inline()
     */
    private array $tasks;


    public function getCollectionItems(): array
    {
        return $this->tasks;
    }
}