<?php

namespace ebitkov\TodoistSDK\API;

use JMS\Serializer\Annotation as Serializer;

class Attachment
{
    /**
     * @Serializer\Type("string")
     */
    private string $fileName;

    /**
     * @Serializer\Type("string")
     */
    private string $fileType;

    /**
     * @Serializer\Type("string")
     */
    private string $fileUrl;

    /**
     * @Serializer\Type("string")
     */
    private string $resourceType;


    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getFileType(): string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): self
    {
        $this->fileType = $fileType;
        return $this;
    }

    public function getFileUrl(): string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }

    public function getResourceType(): string
    {
        return $this->resourceType;
    }

    public function setResourceType(string $resourceType): self
    {
        $this->resourceType = $resourceType;
        return $this;
    }
}