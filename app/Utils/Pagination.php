<?php
namespace App\Utils;

class Pagination
{
    public int $currentPage;
    public int $perPage;
    public int $total;
    public int $lastPage;
    
    public function __construct(int $total, int $perPage = 10, int $currentPage = 1)
    {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->currentPage = max(1, $currentPage);
        $this->lastPage = (int) ceil($total / $perPage);
    }
    
    public function offset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }
    
    public function links(string $baseUrl): string
    {
        if ($this->lastPage <= 1) return '';
        
        $html = '<nav><ul class="pagination">';
        for ($i = 1; $i <= $this->lastPage; $i++) {
            $active = $i === $this->currentPage ? 'active' : '';
            $html .= "<li class='page-item $active'><a class='page-link' href='{$baseUrl}?page=$i'>$i</a></li>";
        }
        $html .= '</ul></nav>';
        
        return $html;
    }
}

