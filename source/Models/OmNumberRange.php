<?php

namespace Objement\OmPhpUtils\Models;

class OmNumberRange
{
    private float $start;
    private float $end;

    /**
     * @param float $start
     * @param float $end
     */
    public function __construct(float $start, float $end)
    {

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return float
     */
    public function getStart(): float
    {
        return $this->start;
    }

    /**
     * @param float $start
     * @return OmNumberRange
     */
    public function setStart(float $start): self
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return float
     */
    public function getEnd(): float
    {
        return $this->end;
    }

    /**
     * @param float $end
     * @return OmNumberRange
     */
    public function setEnd(float $end): self
    {
        $this->end = $end;
        return $this;
    }
}
