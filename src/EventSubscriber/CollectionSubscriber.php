<?php

namespace ebitkov\TodoistSDK\EventSubscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ebitkov\TodoistSDK\Collection\SerializedCollection;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class CollectionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => 'serializer.post_deserialize',
                'method' => 'onPostDeserialize',
                'priority' => -1
            ]
        ];
    }

    public function onPostDeserialize(ObjectEvent $event)
    {
        $coll = $event->getObject();
        if ($coll instanceof Collection and $coll instanceof SerializedCollection) {
            foreach ($coll->getCollectionItems() as $item) {
                $coll->add($item);
            }
        }
    }
}