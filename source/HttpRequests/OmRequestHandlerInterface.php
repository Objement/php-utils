<?php

namespace Objement\OmPhpUtils\HttpRequests;

use DateTime;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerInvalidEmailException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerOutOfDesiredLengthException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerValueNotInWhiteListException;

interface OmRequestHandlerInterface
{
    function getString(string $name): ?string;

    function getInt(string $name, ?int $min = null, ?int $max = null): ?int;

    function getBool(string $name): ?bool;

    function getFloat(string $name, ?float $min = null, ?float $max = null): ?float;

    function getDateTime(string $name, ?DateTime $min = null, ?DateTime $max = null): ?DateTime;

    function getEmail(string $name): ?string;

    function isSet(string $name): bool;

    /**
     * @param string $groupKeyName <input name="products[][name]"> -> Use "products" for the parameter.
     * @return OmRequestHandler[]
     */
    function getRequestHandlersForArray(string $groupKeyName): array;

    /**
     * @param string $name
     * @param bool $allowMultiple
     * @return OmRequestHandlerFileInfoInterface|array|null
     */
    public function getFileInfo(string $name, bool $allowMultiple): OmRequestHandlerFileInfoInterface|array|null;

    /**
     * @param string $name
     * @return array|null
     * @throws OmRequestHandlerInvalidEmailException
     */
    function getArray(string $name): ?array;

    /**
     * @param string $name
     * @param array $whiteList
     * @return string|null
     * @throws OmRequestHandlerOutOfDesiredLengthException
     * @throws OmRequestHandlerValueNotInWhiteListException
     */
    public function getStringForWhiteList(string $name, array $whiteList): ?string;
}
