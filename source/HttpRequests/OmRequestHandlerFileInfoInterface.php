<?php


namespace Objement\OmPhpUtils\HttpRequests;


interface OmRequestHandlerFileInfoInterface
{
    /**
     * @return int
     */
    public function getByteSize(): int;

    /**
     * @return string
     */
    public function getTemporaryName(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
