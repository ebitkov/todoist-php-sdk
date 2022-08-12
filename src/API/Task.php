<?php

namespace ebitkov\TodoistSDK\API;

use ebitkov\TodoistSDK\ClientAware;
use ebitkov\TodoistSDK\ClientTrait;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
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
    private ?string $description;

    /**
     * @Serializer\Type("\ebitkov\TodoistSDK\API\Due")
     */
    private ?Due $due;

    /**
     * @Serializer\Type("ArrayCollection<\ebitkov\TodoistSDK\API\Label>")
     */
    private array $labels;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $order;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $priority;

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


    public static function new(string $content): Task
    {
        return (new self())
            ->setContent($content);
    }


    /**
     * @throws GuzzleException
     */
    public function update(): bool
    {
        return $this->client->updateTask($this);
    }

    /**
     * @throws GuzzleException
     */
    public function createNewTask(Task $task): bool
    {
        $task->setParent($task);
        return $this->client->createNewTask($task);
    }

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

    /**
     * @throws GuzzleException
     */
    public function getParent(): ?Task
    {
        if (null === $this->parent && $this->parentId) {
            $this->parent = $this->client->getActiveTask($this->parentId);
        }

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

    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getAssigneeId(): ?int
    {
        return $this->assigneeId;
    }

    public function getAssignerId(): ?int
    {
        return $this->assignerId;
    }

    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDue(): ?Due
    {
        return $this->due;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function getSectionId(): ?int
    {
        return $this->sectionId;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setAssigneeId(?int $assigneeId): self
    {
        $this->assigneeId = $assigneeId;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setLabels(array $labels): self
    {
        $this->labels = $labels;
        return $this;
    }

    public function setOrder(?int $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function setPriority(?int $priority): self
    {
        if ($priority >= 1 && $priority <= 4) {
            $this->priority = $priority;
            return $this;
        } else {
            throw new InvalidArgumentException('priority has to be from 1 (normal) to 4 (urgent)');
        }
    }

    public function setProjectId(?int $projectId): self
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function setSectionId(?int $sectionId): self
    {
        $this->sectionId = $sectionId;
        return $this;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;
        return $this;
    }
}