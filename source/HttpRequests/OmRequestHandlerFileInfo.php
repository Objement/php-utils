<?php

namespace Objement\OmPhpUtils\HttpRequests;

class OmRequestHandlerFileInfo implements OmRequestHandlerFileInfoInterface
{
    private string $name;
    private string $temporaryName;
    private string $type;
    private int $byteSize;

    /**
     * OmRequestHandlerFileInfo constructor.
     * @param string $name
     * @param string $temporaryName
     * @param string $type
     * @param int $byteSize
     */
    public function __construct(string $name, string $temporaryName, string $type, int $byteSize)
    {
        $this->name = $name;
        $this->temporaryName = $temporaryName;
        $this->type = $type;
        $this->byteSize = $byteSize;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTemporaryName(): string
    {
        return $this->temporaryName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getByteSize(): int
    {
        return $this->byteSize;
    }
}
