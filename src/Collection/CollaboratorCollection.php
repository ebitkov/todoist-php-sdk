<?php

namespace ebitkov\TodoistSDK\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class CollaboratorCollection extends ArrayCollection implements SerializedCollection
{
    /**
     * @Serializer\Type("array<ebitkov\TodoistSDK\API\Collaborator>")
     * @Serializer\Inline()
     */
    private array $collaborators;


    public function getCollectionItems(): array
    {
        return $this->collaborators;
    }
}