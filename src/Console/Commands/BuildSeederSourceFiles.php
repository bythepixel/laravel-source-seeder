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
    protected $signature = 'seeders:build {table?} {--connection= : The database connection to use}';

    protected $description = 'Build source files for specified table. If no parameter is passed, all versioned database tables will be built.';

    private array $tables = [
        // add table names
    ];

    public function handle()
    {
        $targetTable = $this->argument('table');
        $path = $this->getSourcePath();
        $fs = new Filesystem(new LocalFilesystemAdapter(database_path($path)));

        $tables = $targetTable === null ? $this->tables : [$targetTable];

        foreach ($tables as $table) {
            $this->buildTable($table, $fs);
        }
    }

    private function buildTable(string $table, Filesystem $sourceFs)
    {
        $data = [];
        $connection = $this->option('connection') ?: config('database.default');
        $result = DB::connection($connection)->table($table)->get('*');

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

    private function getSourcePath(): string
    {
        $path = database_path('seeders/Source');
        if ($this->hasOption('connection')) {
            $path .= DIRECTORY_SEPARATOR . $this->option('connection');
        }

        return $path;
    }
}
