<?php

namespace ebitkov\TodoistSDK\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class SectionCollection extends ArrayCollection implements SerializedCollection
{
    /**
     * @Serializer\Type("array<ebitkov\TodoistSDK\API\Section>")
     * @Serializer\Inline()
     */
    private array $sections;


    public function getCollectionItems(): array
    {
        return $this->sections;
    }
}