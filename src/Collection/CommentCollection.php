<?php

namespace ebitkov\TodoistSDK\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class CommentCollection extends ArrayCollection implements SerializedCollection
{
    /**
     * @Serializer\Type("array<ebitkov\TodoistSDK\API\Comment>")
     * @Serializer\Inline()
     */
    private array $comments;


    public function getCollectionItems(): array
    {
        return $this->comments;
    }
}