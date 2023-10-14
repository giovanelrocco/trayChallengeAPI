<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MailService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $service;

    public function __construct(MailService $service)
    {
        $this->service = $service;
    }

    public function enviarAdminEmail()
    {
        $this->service->enviarEmailAdmin();

        return response('', 201)
            ->header('Content-Type', 'application/json');
    }

    public function enviarLoteEmail()
    {
        $this->service->enviarLoteEmail();

        return response('', 201)
            ->header('Content-Type', 'application/json');

    }

    public function enviarEmail(Request $request)
    {
        $this->service->enviarEmail($request->id);

        return response('', 201)
            ->header('Content-Type', 'application/json');
    }
}
