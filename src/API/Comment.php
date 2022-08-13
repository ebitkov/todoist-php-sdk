<?php

namespace ebitkov\TodoistSDK\API;

use DateTime;
use ebitkov\TodoistSDK\ClientAware;
use ebitkov\TodoistSDK\ClientTrait;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\Annotation as Serializer;

class Comment implements ClientAware
{
    use ClientTrait;


    /**
     * @Serializer\Type("integer")
     */
    private int $id;

    /**
     * @Serializer\Type("string")
     */
    private string $content;

    /**
     * @Serializer\Type("DateTime")
     */
    private DateTime $postedAt;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $projectId;

    private ?Project $project;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $taskId;

    private ?Task $task;

    /**
     * @Serializer\Type("\ebitkov\TodoistSDK\API\Attachment")
     */
    private ?Attachment $attachment;


    public static function new(string $content, Attachment $attachment = null): Comment
    {
        return (new self())
            ->setContent($content)
            ->setAttachment($attachment);
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getPostedAt(): DateTime
    {
        return $this->postedAt;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId): self
    {
        $this->projectId = $projectId;
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

    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    public function setTaskId(?int $taskId): self
    {
        $this->taskId = $taskId;
        return $this;
    }

    /**
     * @throws GuzzleException
     */
    public function getTask(): ?Task
    {
        if (null === $this->task && $this->taskId) {
            $this->task = $this->client->getActiveTask($this->taskId);
        }

        return $this->task;
    }

    public function getAttachment(): ?Attachment
    {
        return $this->attachment;
    }

    public function setAttachment(?Attachment $attachment): self
    {
        $this->attachment = $attachment;
        return $this;
    }
}