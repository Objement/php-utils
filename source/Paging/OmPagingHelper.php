<?php

declare(strict_types=1);

namespace Objement\OmPhpUtils\Paging;

class OmPagingHelper
{
    private int $currentPage = 1;
    private int $entriesPerPage;
    private int $totalEntryCount;

    /**
     * @param int $totalEntryCount
     * @param int $entriesPerPage
     */
    public function __construct(int $totalEntryCount, int $entriesPerPage = 20)
    {
        $this->entriesPerPage = $entriesPerPage;
        $this->totalEntryCount = $totalEntryCount;
    }

    public function setRequestedPageNumber(?int $requestedPage): self
    {
        if (!$requestedPage || $requestedPage < 1 || $requestedPage > $this->getTotalPages()) {
            $this->currentPage = 1;
        } else {
            $this->currentPage = $requestedPage;
        }

        return $this;
    }

    /**
     * Calculates and returns the number of pages depending on the available entries and the desired number of entries per page.
     * @return int
     */
    public function getTotalPages(): int
    {
        if (!$this->totalEntryCount) {
            return 1;
        }

        return (int)ceil($this->totalEntryCount / $this->getEntriesPerPage());
    }

    /**
     * @return int
     */
    public function getEntriesPerPage(): int
    {
        return $this->entriesPerPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getTotalEntryCount(): int
    {
        return $this->totalEntryCount;
    }
}
