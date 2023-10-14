<?php

namespace App\Console\Commands;

use App\Repositories\VendaRepository;
use App\Repositories\VendedorRepository;
use App\Services\MailService;
use Illuminate\Console\Command;

class DispararEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:disparar-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $venda_repository;
    protected $vendedor_repository;

    public function __construct(VendaRepository $venda_repository, VendedorRepository $vendedor_repository)
    {
        parent::__construct();
        $this->venda_repository = $venda_repository;
        $this->vendedor_repository = $vendedor_repository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new MailService($this->venda_repository, $this->vendedor_repository);
        $service->enviarLoteEmail();
        $service->enviarEmailAdmin();
    }
}
