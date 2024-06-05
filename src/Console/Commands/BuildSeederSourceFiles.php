<?php

namespace LaravelSourceSeeder\Console\Commands;

use Illuminate\{
    Console\Command,
    Support\Facades\DB
};
use League\Flysystem\{
    Local\LocalFilesystemAdapter,
    Filesystem
};

class BuildSeederSourceFiles extends Command
{
    protected $signature = 'seeders:build {table?}';

    protected $description = 'Build source files for specified table. If no parameter is passed, all versioned database tables will be built.';

    private array $tables = [
        // add table names
    ];

    public function handle()
    {
        $targetTable = $this->argument('table');
        $fs = new Filesystem(new LocalFilesystemAdapter(database_path('seeders/Source')));

        $tables = $targetTable === null ? $this->tables : [$targetTable];

        foreach ($tables as $table) {
            $this->buildTable($table, $fs);
        }
    }

    private function buildTable(string $table, Filesystem $sourceFs)
    {
        $data = [];
        $result = DB::table($table)->get('*');

        foreach ($result as $row) {
            $data[] = (array)$row;
        }

        $json = json_encode($data, JSON_PRETTY_PRINT);

        if (empty($json)) {
            $this->error("Cannot build $table seeder - no data!");
            return;
        }

        $sourceFs->write("$table.json", $json);

        $this->info("Successfully built seeder for $table");
    }
}
