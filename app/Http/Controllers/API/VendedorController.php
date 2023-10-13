<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\VendedorRepository;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

class VendedorController extends Controller
{
    use HasApiTokens;

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
            return response('Vendedor não encontrado', 404);
        }

        return response()->json($vendedor);
    }

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required',
                'email' => 'required|unique:App\Models\Vendedor',
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response($th->validator->errors(), 422);
        }

        $this->repository->saveOrUpdate(null, $request->all());
        return response('', 201)
            ->header('Content-Type', 'application/json');
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response($th->validator->errors(), 422);
        }

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
