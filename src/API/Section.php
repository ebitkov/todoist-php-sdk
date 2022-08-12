<?php

namespace ebitkov\TodoistSDK\API;

use ebitkov\TodoistSDK\ClientAware;
use ebitkov\TodoistSDK\ClientTrait;
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