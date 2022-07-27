<?php

namespace ebitkov\TodoistSDK\API;

use JMS\Serializer\Annotation as Serializer;

class Collaborator
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
    private ?string $email;


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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }
}