<?php
namespace App\Core;

class QueryBuilder
{
    protected string $select = '*';
    protected string $from = '';
    protected array $where = [];
    protected array $params = [];
    
    public function select(string $columns): self
    {
        $this->select = $columns;
        return $this;
    }
    
    public function from(string $table): self
    {
        $this->from = $table;
        return $this;
    }
    
    public function where(string $condition, $value): self
    {
        $paramKey = 'param_' . count($this->params);
        $this->where[] = str_replace('?', ':' . $paramKey, $condition);
        $this->params[$paramKey] = $value;
        return $this;
    }
    
    public function build(): array
    {
        $sql = "SELECT {$this->select} FROM {$this->from}";
        
        if (!empty($this->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->where);
        }
        
        return ['sql' => $sql, 'params' => $this->params];
    }
}

