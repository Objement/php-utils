<?php

namespace Objement\OmPhpUtils\Filters;

class OmQuerySorting
{
    const DIRECTION_ASCENDING = 'ASC';
    const DIRECTION_DESCENDING = 'DESC';
    private string $direction;
    private string $name;

    private function __construct(string $direction, string $name)
    {

        $this->direction = $direction;
        $this->name = $name;
    }

    public static function ascending($name): self
    {
        return new self(self::DIRECTION_ASCENDING, $name);
    }

    public static function descending($name): self
    {
        return new self(self::DIRECTION_DESCENDING, $name);
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
