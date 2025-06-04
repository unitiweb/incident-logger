<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbReset extends Command
{
    protected $signature = 'db:reset';
    protected $description = 'Clear all MongoDB collections and reseed departments';

    public function handle()
    {
        $this->info('Dropping all MongoDB collections...');
        $collections = DB::connection('mongodb')->getMongoDB()->listCollections();
        foreach ($collections as $collection) {
            $name = $collection->getName();
            DB::connection('mongodb')->getMongoDB()->dropCollection($name);
            $this->line("Dropped: $name");
        }

        $this->info('Reseeding departments...');
        $this->call('db:seed', ['--class' => 'Database\\Seeders\\DepartmentSeeder']);

        $this->info('Database cleared and departments reseeded!');
        return 0;
    }
}