<?php

namespace App\Services;

use App\Repositories\VendedorRepository;

class VendedorService
{

    protected $repository;

    public function __construct(VendedorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function save(array $data)
    {
        return $this->repository->save($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroyById(int $id)
    {
        return $this->repository->destroyById($id);
    }

}
