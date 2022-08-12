<?php

namespace ebitkov\TodoistSDK\API;

use ebitkov\TodoistSDK\ClientAware;
use ebitkov\TodoistSDK\ClientTrait;
use ebitkov\TodoistSDK\Collection\TaskCollection;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\Annotation as Serializer;

class Section implements ClientAware
{
    use ClientTrait;

    /**
     * @Serializer\Type("integer")
     */
    private int $id;

    /**
     * @Serializer\Type("string")
     */
    private string $name;

    /**
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("project_id")
     */
    private int $projectId;

    private ?Project $project;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $order;


    public static function new(int $projectId, string $name): Section
    {
        return (new self())
            ->setProjectId($projectId)
            ->setName($name);
    }

    /**
     * @throws GuzzleException
     */
    public function update(): bool
    {
        return $this->client->updateSection($this);
    }

    /**
     * @throws GuzzleException
     */
    public function delete(): bool
    {
        return $this->client->deleteSection($this->getId());
    }

    /**
     * @throws GuzzleException
     */
    public function getActiveTasks(): ?TaskCollection
    {
        return $this->client->getActiveTasks(['section_id' => $this->getId()]);
    }

    /**
     * @throws GuzzleException
     */
    public function createNewTask(Task $task): bool
    {
        $task->setSection($this);
        return $this->client->createNewTask($task);
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;
        return $this;
    }

    /**
     * @throws GuzzleException
     */
    public function getProject(): ?Project
    {
        if (null === $this->project) {
            $this->setProject($this->client->getProject($this->projectId));
        }

        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;
        $this->setProjectId($project->getId());

        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}