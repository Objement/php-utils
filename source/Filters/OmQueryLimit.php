<?php

namespace Objement\OmPhpUtils\Filters;

class OmQueryLimit
{
    private ?int $start;
    private int $length;

    public function __construct(int $length, ?int $start)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public static function forLength(int $length): self
    {
        return new self($length, null);
    }

    public static function startFromForLength(int $start, int $length): self
    {
        return new self($length, $start);
    }

    /**
     * @return int|null
     */
    public function getStart(): ?int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }
}
