<?php

namespace ebitkov\TodoistSDK\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class ProjectCollection extends ArrayCollection implements SerializedCollection
{
    /**
     * @Serializer\Type("array<ebitkov\TodoistSDK\Project>")
     * @Serializer\Inline()
     */
    private array $projects;


    public function getCollectionItems(): array
    {
        return $this->projects;
    }
}