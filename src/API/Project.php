<?php

namespace ebitkov\TodoistSDK\API;

use ebitkov\TodoistSDK\ClientAware;
use ebitkov\TodoistSDK\ClientTrait;
use ebitkov\TodoistSDK\Resource;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\Annotation as Serializer;

class Project implements ClientAware
{
    use ClientTrait;


    /**
     * @Serializer\Type("integer")
     */
    private ?int $id;

    /**
     * @Serializer\Type("string")
     */
    private ?string $name;

    /**
     * @Serializer\Type("string")
     */
    private ?string $color = null;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $parentId = null;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $order = null;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $commentCount = null;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isShared = null;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isFavorite = null;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isInboxProject = null;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isTeamInbox = null;

    /**
     * @Serializer\Type("string")
     */
    private ?string $viewStyle = null;

    /**
     * @Serializer\Type("string")
     */
    private ?string $url = null;


    /**
     * Creates a new project with the available parameters.
     */
    public static function new(string $name, string $colorName = null, bool $isFavorite = null, string $viewStyle = null): Project
    {
        return (new self())
            ->setName($name)
            ->setColor($colorName)
            ->setIsFavorite($isFavorite)
            ->setViewStyle($viewStyle);
    }

    /**
     * @throws GuzzleException
     */
    public function update(): bool
    {
        return $this->client->updateProject($this);
    }

    /**
     * @throws GuzzleException
     */
    public function delete(): bool
    {
        return $this->client->deleteProject($this->getId());
    }

    /**
     * Creates a new subproject.
     * @throws GuzzleException
     */
    public function createNewProject(Project $project): ?Project
    {
        return $this->client->createNewProject($project->setParentId($this->getId()));
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        if ($color && Colors::isValid($color)) $this->color = $color;
        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getCommentCount(): ?int
    {
        return $this->commentCount;
    }

    public function setCommentCount(?int $commentCount): self
    {
        $this->commentCount = $commentCount;
        return $this;
    }

    public function getIsShared(): ?bool
    {
        return $this->isShared;
    }

    public function setIsShared(?bool $isShared): self
    {
        $this->isShared = $isShared;
        return $this;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(?bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;
        return $this;
    }

    public function getIsInboxProject(): ?bool
    {
        return $this->isInboxProject;
    }

    public function setIsInboxProject(?bool $isInboxProject): self
    {
        $this->isInboxProject = $isInboxProject;
        return $this;
    }

    public function getIsTeamInbox(): ?bool
    {
        return $this->isTeamInbox;
    }

    public function setIsTeamInbox(?bool $isTeamInbox): self
    {
        $this->isTeamInbox = $isTeamInbox;
        return $this;
    }

    public function getViewStyle(): ?string
    {
        return $this->viewStyle;
    }

    public function setViewStyle(?string $viewStyle): self
    {
        $this->viewStyle = $viewStyle;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }
}