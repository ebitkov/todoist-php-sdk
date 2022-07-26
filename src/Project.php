<?php

namespace ebitkov\TodoistSDK;

use JMS\Serializer\Annotation as Serializer;

class Project
{
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
    private ?string $color;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $parentId;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $order;

    /**
     * @Serializer\Type("integer")
     */
    private ?int $commentCount;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isShared;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isFavorite;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isInboxProject;

    /**
     * @Serializer\Type("boolean")
     */
    private ?bool $isTeamInbox;

    /**
     * @Serializer\Type("string")
     */
    private ?string $viewStyle;

    /**
     * @Serializer\Type("string")
     */
    private ?string $url;


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
        $this->color = $color;
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