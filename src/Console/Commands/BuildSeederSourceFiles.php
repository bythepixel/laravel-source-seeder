<?php

namespace LaravelSourceSeeder\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class BuildSeederSourceFiles extends Command
{
    protected $signature = 'seeders:build {table}';

    protected $description = 'Build source files for specified table.';

    public function handle()
    {
        $fs = new Filesystem(new LocalFilesystemAdapter(database_path(config('source-seeder.directory'))));

        $this->buildTable($this->argument('table'), $fs);
    }

    private function buildTable(string $table, Filesystem $sourceFs)
    {
        $result = DB::table($table)->get('*');

        if ($result->isEmpty()) {
            $this->error("Cannot build $table seeder - no data!");

            return;
        }

        $json = $result->toJson(JSON_PRETTY_PRINT);

        try {
            $sourceFs->write("$table.json", $json);
        } catch(\Throwable $e) {
            $this->error($e->getMessage());

            return;
        }

        $this->info("Successfully built seeder for $table");
    }
}
