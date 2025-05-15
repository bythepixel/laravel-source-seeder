<?php

namespace LaravelSourceSeeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class SourceSeederInternal extends Seeder
{
    /**
     * Derive table name from the implemented class name
     *
     * @return string
     */
    private function getType(): string
    {
        $className = substr(strrchr(str_replace('Seeder', '', get_class($this)), "\\"), 1);

        return Str::snake(Str::plural($className));
    }

    public function run()
    {
        $path = $this->getSourcePath();

        $fs = new Filesystem(new Local($path));
        $type = $this->getType();

        try {
            $json = $fs->read("$type.json");
        } catch (\Exception $e) {
            $message = "Warning: Seeder Source does not exist for $type at $path";
            Log::warning($message);
            echo "$message\n";
            return;
        }

        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            Log::error('Unable to parse JSON: ' . json_last_error());
        }

        foreach ($data as $row) {
            $result = DB::table($type)->where('id', $row['id'])->get('*')->first();

            if ($result) {
                DB::table($type)->where('id', $result->id)->update($row);
            } else {
                DB::table($type)->insert($row);
            }
        }
    }

    private function getSourcePath(): string
    {
        $path = 'seeders/Source';
        if ($this->command->hasOption('database')) {
            $connection = $this->command->option('database');
            $path .= DIRECTORY_SEPARATOR . $connection;
        }

        return $path;
    }
}
