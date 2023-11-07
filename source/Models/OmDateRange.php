<?php

namespace Objement\OmPhpUtils\Models;

use DateTime;

class OmDateRange
{
    private DateTime $start;
    private DateTime $end;

    /**
     * @param DateTime $start
     * @param DateTime $end
     */
    public function __construct(DateTime $start, DateTime $end)
    {

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return DateTime
     */
    public function getStart(): DateTime
    {
        return $this->start;
    }

    /**
     * @param DateTime $start
     * @return OmDateRange
     */
    public function setStart(DateTime $start): self
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEnd(): DateTime
    {
        return $this->end;
    }

    /**
     * @param DateTime $end
     * @return OmDateRange
     */
    public function setEnd(DateTime $end): self
    {
        $this->end = $end;
        return $this;
    }
}
