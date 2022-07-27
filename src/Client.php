<?php

namespace ebitkov\TodoistSDK;

use Doctrine\Common\Collections\ArrayCollection;
use ebitkov\TodoistSDK\API\Project;
use ebitkov\TodoistSDK\Collection\ProjectCollection;
use ebitkov\TodoistSDK\EventSubscriber\CollectionSubscriber;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class Client extends \GuzzleHttp\Client
{
    const API_URL = 'https://api.todoist.com/rest/v2/';


    private Serializer $serializer;


    public function __construct(string $token, array $guzzleConfig = [])
    {
        $builder = SerializerBuilder::create();

        $client = $this;
        $builder->configureListeners(function (EventDispatcher $dispatcher) use ($client) {
            $dispatcher->addListener('serializer.post_deserialize', function (ObjectEvent $event) use ($client) {
                $object = $event->getObject();
                if ($object instanceof ClientAware) {
                    $object->setClient($client);
                }
            });
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

    /**
     * Creates a new project.
     *
     * @throws GuzzleException
     */
    public function createNewProject(Project $project): ?Project
    {
        $data = [
            'name' => $project->getName(),
            'parent_id' => $project->getParentId(),
            'color' => $project->getColor(),
            'is_favorite' => $project->getIsFavorite(),
            'view_style' => $project->getViewStyle()
        ];

        $response = $this->post(Resource::PROJECTS, ['json' => $data]);
        if ($response->getStatusCode() === 200) {
            $project = $this->serializer->deserialize($response->getBody()->getContents(), Project::class, 'json');
            $project->setClient($this);

            return $project;
        }

        return null;
    }

    public function getProject(int $projectId): ?Project
    {
        $response = $this->get(sprintf('%s/%d', Resource::PROJECTS, $projectId));
        if ($response->getStatusCode() === 200) {
            $project = $this->serializer->deserialize($response->getBody()->getContents(), Project::class, 'json');
            $project->setClient($this);

            return $project;
        }

        return null;
    }

    /**
     * Posts changes to the API.
     *
     * @throws GuzzleException
     */
    public function updateProject(Project $project): bool
    {
        if (null !== $project->getId()) {
            $response = $this->post(
                sprintf('%s/%d', Resource::PROJECTS, $project->getId()), [
                'json' => [
                    'name' => $project->getName(),
                    'color' => $project->getColor(),
                    'is_favorite' => $project->getIsFavorite(),
                    'view_style' => $project->getViewStyle()
                ]
            ]);

            return $response->getStatusCode() === 204;
        } else {
            throw new InvalidArgumentException('%s is not a valid project - ID is missing.', $project->getName());
        }
    }

    /**
     * Deletes a project.
     *
     * @throws GuzzleException
     */
    public function deleteProject(int $projectId): bool
    {
        $response = $this->delete(sprintf('%s/%d', Resource::PROJECTS, $projectId));
        return $response->getStatusCode() === 204;
    }
}