<?php

namespace App\Http\Controllers;

use App\Repositories\VendedorRepository;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    protected $repository;

    public function __construct(VendedorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $vendedores = $this->repository->list();
        return response()->json($vendedores);
    }

    public function show(int $id)
    {
        $vendedor = $this->repository->findById($id);

        if (!$vendedor) {
            throw new \Exception('Vendedor não encontrado');
        }

        return response()->json($vendedor);
    }

    public function create(Request $request)
    {
        $this->repository->saveOrUpdate(null, $request->all());
        return response('', 201)
            ->header('Content-Type', 'application/json');

    }

    public function update(Request $request)
    {
        $this->repository->saveOrUpdate($request->id, $request->all());

        return response('', 204)
            ->header('Content-Type', 'application/json');

    }

    public function delete(Request $request)
    {
        $this->repository->destroyById($request->id);

        return response('', 204)
            ->header('Content-Type', 'application/json');

    }
}
