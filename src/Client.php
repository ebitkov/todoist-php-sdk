<?php

namespace ebitkov\TodoistSDK;

use Doctrine\Common\Collections\ArrayCollection;
use ebitkov\TodoistSDK\Collection\ProjectCollection;
use ebitkov\TodoistSDK\EventSubscriber\CollectionSubscriber;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class Client extends \GuzzleHttp\Client
{
    const API_URL = 'https://api.todoist.com/rest/v2/';


    private Serializer $serializer;


    public function __construct(string $token, array $guzzleConfig = [])
    {
        $builder = SerializerBuilder::create();

        $builder->configureListeners(function (EventDispatcher $dispatcher) {
            $dispatcher->addSubscriber(new CollectionSubscriber());
        });

        $this->serializer = $builder->build();

        $config = $guzzleConfig;

        $config['base_uri'] = self::API_URL;
        $config['headers']['Authorization'] = sprintf('Bearer %s', $token);

        parent::__construct($config);
    }

    /**
     * Gets all projects.
     *
     * @link https://developer.todoist.com/rest/v2/#projects
     *
     * @return ArrayCollection|Project[]
     *
     * @throws GuzzleException
     */
    public function getAllProjects(): ?ProjectCollection
    {
        if (
            ($response = $this->get(Resource::PROJECTS))
            && $response->getStatusCode() === 200
        ) {
            $content = $response->getBody()->getContents();
            return $this->serializer->deserialize($content, ProjectCollection::class, 'json');
        }

        return null;
    }
}