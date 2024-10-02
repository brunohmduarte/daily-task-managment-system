<?php

namespace Application\Helper;

use Application\Core;

class Paginator
{
    /** @var array $records */
    public $records;

    /** @var string $route */
    public $route;

    /** @var int $perPage */
    public $perPage;

    /** @var int $startCount */
    public $startCount;

    /** @var int $currentPage */
    public $currentPage;

    public function __construct(
        array $records,
        string $route, 
        int $currentPage = 1,
        int $perPage = 10, 
        int $startCount = 0
    ) {
        $this->records = $records;
        $this->route = $route;
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->startCount = $startCount;
    }

    public function render(): array
    {
        /** @todo Gerar a URI fora do loop 'for' para preservar os parametros de outras funcionalidades. */
        $nav = [];
        for ($i=1; $i <= $this->totalNumberLinks(); $i++) {
            $url = sprintf('admin/%s.php?page=%d', $this->route, $i);
            $nav[] = [
                'url' => Core::getUrlBase($url),
                'active' => ($this->currentPage == $i)
            ];
        }

        return $nav;
    }

    public function paginate(): array
    {
        $start = ($this->currentPage - 1) * $this->perPage;
        return array_slice($this->records, $start, $this->perPage);
    }

    public function getLinkStart(): string
    {
        return sprintf('admin/%s.php?page=%d', $this->route, 1);
    }

    public function getLinkEnd(): string
    {
        return sprintf('admin/%s.php?page=%d', $this->route, $this->totalNumberLinks());
    }

    public function totalNumberLinks() 
    {
        $grandTotal = count($this->records);
        $totalLinks = ceil($grandTotal / $this->perPage);
        return intval($totalLinks);
    }
}
