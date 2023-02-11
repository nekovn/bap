<?php

namespace App\Services;
trait BaseServiceTrait
{

    public function find(array $conditions, $first = false)
    {
        return $this->repository->find($conditions, $first);
    }

    public function findByPkey(array $where, bool $includeInActive = false, array $select = ['*'], $with = ''): array
    {
        return $this->repository->findByPkey($where, $includeInActive, $select, $with);
    }

    public function delete(array $conditions = [])
    {
        return $this->repository->delete($conditions);
    }

    public function search($keyword, $search)
    {
        return $this->repository->search($keyword, $search);
    }

    public function create(array $values)
    {
        return $this->repository->create($values);
    }

    public function update(array $values, string $id): bool
    {
        return $this->repository->update($values, $id);
    }

    public function getLastRow(string $column)
    {
        return $this->repository->getLastRow($column);
    }
}
