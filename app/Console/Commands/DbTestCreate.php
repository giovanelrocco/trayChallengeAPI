<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbTestCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:db-test-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new postgres database for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $db_name = "testtraychallenge";

            $hasDb = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . $db_name . "'");

            if (empty($hasDb)) {
                DB::select('CREATE DATABASE ' . $db_name);
                $this->info("Database '$db_name' created.");
            } else {
                $this->info("Database $db_name already exists.");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

    }
}
