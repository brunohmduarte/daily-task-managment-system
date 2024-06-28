<?php

namespace Application\Model\Resources;

trait SearchTrait
{
    public function getCollection() 
    {
        return $this->find()->fetch(true);
    }

    public function findByField(string $field, string $value, bool $all = false)
    {
        return $this->find("{$field} = :field", "field={$value}")->fetch($all);
    }

    public function like(string $field, string $searchValue) 
    {
        if (empty($field) && empty($searchValue)) {
            return;
        }
        if (!str_contains($this->statement, "WHERE")) {
            $this->statement .= " WHERE {$field} LIKE '%{$searchValue}%'";
        } else {
            $this->statement .= " OR {$field} LIKE '%{$searchValue}%'";
        }
        
        return $this;
    }

    public function innerJoin(array $entityJoin, string $keyJoin) 
    {
        if (empty($entityJoin) || empty($keyJoin)) {
            return;
        }
        
        $alias = array_key_first($entityJoin);
        $entity = $entityJoin[$alias];
        $join = sprintf(' INNER JOIN %s ON(%s)', "{$entity} AS {$alias}", $keyJoin);

        $this->statement .= $join;

        return $this;
    }

    public function leftJoin(array $entityJoin, string $keyJoin) 
    {
        if (empty($entityJoin) || empty($keyJoin)) {
            return;
        }
        
        $alias = array_key_first($entityJoin);
        $entity = $entityJoin[$alias];
        $join = sprintf(' LEFT JOIN %s ON(%s)', "{$entity} AS {$alias}", $keyJoin);

        $this->statement .= $join;

        return $this;
    }

    public function rightJoin(array $entityJoin, string $keyJoin) 
    {
        if (empty($entityJoin) || empty($keyJoin)) {
            return;
        }
        
        $alias = array_key_first($entityJoin);
        $entity = $entityJoin[$alias];
        $join = sprintf(' RIGHT JOIN %s ON(%s)', "{$entity} AS {$alias}", $keyJoin);

        $this->statement .= $join;

        return $this;
    }

    public function where(string $field, array $conditions) 
    {
        if (empty($field) || empty($conditions)) {
            return;
        }

        foreach ($conditions as $key => $value) {
            if (!str_contains($this->statement, "WHERE")) {
                $this->statement .= " WHERE {$field} {$key} {$value}";
            } else {
                $this->statement .= " OR {$field} {$key} {$value}";
            }
        }

        return $this;
    }

    public function getQuerySql()
    {
        return $this->statement;
    }
}
