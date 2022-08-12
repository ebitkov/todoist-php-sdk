<?php

namespace ebitkov\TodoistSDK;

use Doctrine\Common\Collections\ArrayCollection;
use ebitkov\TodoistSDK\API\Project;
use ebitkov\TodoistSDK\API\Section;
use ebitkov\TodoistSDK\Collection\CollaboratorCollection;
use ebitkov\TodoistSDK\Collection\ProjectCollection;
use ebitkov\TodoistSDK\Collection\SectionCollection;
use ebitkov\TodoistSDK\EventSubscriber\CollectionSubscriber;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class Client
{
    const API_URL = 'https://api.todoist.com/rest/v2/';


    private Serializer $serializer;

    private \GuzzleHttp\Client $guzzle;


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

        $this->guzzle = new \GuzzleHttp\Client($config);
    }

    /**
     * @throws GuzzleException
     */
    private function getAll(string $resource, string $type, array $options = [])
    {
        if (
            ($response = $this->guzzle->get($resource, $options))
            && $response->getStatusCode() === 200
        ) {
            $content = $response->getBody()->getContents();
            return $this->serializer->deserialize($content, $type, 'json');
        }

        return null;
    }

    /**
     * @throws GuzzleException
     */
    private function get(string $resource, string $type)
    {
        $response = $this->guzzle->get($resource);
        if ($response->getStatusCode() === 200) {
            $item = $this->serializer->deserialize($response->getBody()->getContents(), $type, 'json');
            if ($item instanceof ClientAware) {
                $item->setClient($this);
            }

            return $item;
        }

        return null;
    }

    /**
     * @throws GuzzleException
     */
    private function createNew(string $resource, string $type, array $data)
    {
        $response = $this->guzzle->post($resource, ['json' => $data]);
        if ($response->getStatusCode() === 200) {
            $project = $this->serializer->deserialize($response->getBody()->getContents(), $type, 'json');
            $project->setClient($this);

            return $project;
        }

        return null;
    }

    /**
     * @throws GuzzleException
     */
    private function update(string $resource, array $data): bool
    {
        $response = $this->guzzle->post(
            $resource,
            [
                'json' => $data
            ]
        );

        return $response->getStatusCode() === 204;
    }

    /**
     * @throws GuzzleException
     */
    private function delete(string $resource): bool
    {
        $response = $this->guzzle->delete($resource);
        return $response->getStatusCode() === 204;
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
        return $this->getAll(Resource::PROJECTS(), ProjectCollection::class);
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

        return $this->createNew(Resource::PROJECTS(), Project::class, $data);
    }

    /**
     * @throws GuzzleException
     */
    public function getProject(int $projectId): ?Project
    {
        return $this->get(Resource::PROJECTS($projectId), Project::class);
    }

    /**
     * Posts changes to the API.
     *
     * @throws GuzzleException
     */
    public function updateProject(Project $project): bool
    {
        if (null !== $project->getId()) {
            return $this->update(Resource::PROJECTS($project->getId()), [
                'name' => $project->getName(),
                'color' => $project->getColor(),
                'is_favorite' => $project->getIsFavorite(),
                'view_style' => $project->getViewStyle()
            ]);
        } else {
            throw new InvalidArgumentException(sprintf(
                '%s is not a valid project - ID is missing.',
                $project->getName()
            ));
        }
    }

    /**
     * Deletes a project.
     *
     * @throws GuzzleException
     */
    public function deleteProject(int $projectId): bool
    {
        return $this->delete(Resource::PROJECTS($projectId));
    }

    /**
     * @throws GuzzleException
     */
    public function getAllCollaborators(int $projectId): ?CollaboratorCollection
    {
        return $this->getAll(Resource::COLLABORATORS($projectId), CollaboratorCollection::class);
    }

    /**
     * @throws GuzzleException
     */
    public function getAllSections(int $projectId): ?SectionCollection
    {
        return $this->getAll(Resource::SECTIONS(), SectionCollection::class, [
            'project_id' => $projectId
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function createNewSection(Section $section): ?Section
    {
        $data = [
            'project_id' => $section->getProjectId(),
            'name' => $section->getName(),
        ];

        return $this->createNew(Resource::SECTIONS(), Section::class, $data);
    }

    /**
     * @throws GuzzleException
     */
    public function getSection(int $sectionId): ?Section
    {
        return $this->get(Resource::SECTIONS($sectionId), Section::class);
    }

    /**
     * @throws GuzzleException
     */
    public function updateSection(Section $section): bool
    {
        if (null !== $section->getId()) {
            return $this->update(Resource::SECTIONS($section->getId()), [
                'name' => $section->getName()
            ]);
        } else {
            throw new InvalidArgumentException(
                sprintf('section %s in project %s is not valid - ID is missing.',
                    $section->getName(),
                    $section->getProject()->getName()
                ));
        }
    }

    /**
     * @throws GuzzleException
     */
    public function deleteSection(int $sectionId): bool
    {
        return $this->delete(Resource::SECTIONS($sectionId));
    }
}