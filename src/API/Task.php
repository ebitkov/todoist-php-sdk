<?php

namespace ebitkov\TodoistSDK\API;

use ebitkov\TodoistSDK\ClientAware;
use ebitkov\TodoistSDK\ClientTrait;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\Annotation as Serializer;

class Task implements ClientAware
{
    use ClientTrait;

    /**
     * @Serializer\Type("integer")
     */
    private int $id;

    /**
     * @Serializer\Type("integer")
     */
    private int $creatorId;

    /**
     * @Serializer\Type("DateTime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $assigneeId;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $assignerId;

    /**
     * @Serializer\Type("integer")
     */
    private int $commentCount;

    /**
     * @Serializer\Type("boolean")
     */
    private bool $isCompleted;

    /**
     * @Serializer\Type("string")
     */
    private string $content;

    /**
     * @Serializer\Type("string")
     */
    private string $description;

    /**
     * @Serializer\Type("\ebitkov\TodoistSDK\API\Due")
     */
    private Due $due;

    /**
     * @Serializer\Type("ArrayCollection<\ebitkov\TodoistSDK\API\Label>")
     */
    private array $labels;

    /**
     * @Serializer\Type("integer")
     */
    private int $order;

    /**
     * @Serializer\Type("integer")
     */
    private int $priority;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $projectId;

    private ?Project $project;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $sectionId;

    private ?Section $section;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $parentId;

    private ?Task $parent;

    /**
     * @Serializer\Type("string")
     */
    private string $url;


    public function setProject(?Project $project): self
    {
        $this->project = $project;
        $this->projectId = $project->getId();

        return $this;
    }

    /**
     * @throws GuzzleException
     */
    public function getProject(): ?Project
    {
        if (null === $this->project && $this->projectId) {
            $this->project = $this->client->getProject($this->projectId);
        }

        return $this->project;
    }

    /**
     * @throws GuzzleException
     */
    public function getSection(): ?Section
    {
        if (null === $this->section && $this->sectionId) {
            $this->section = $this->client->getSection($this->sectionId);
        }

        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;
        $this->sectionId = $section->getId();

        return $this;
    }

    public function getParent(): ?Task
    {
        # todo: load task if missing
        return $this->parent;
    }

    public function setParent(?Task $parent): self
    {
        $this->parent = $parent;
        $this->parentId = $parent->getId();
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}