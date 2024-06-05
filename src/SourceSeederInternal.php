<?php

namespace LaravelSourceSeeder;

use Illuminate\{
    Database\Seeder,
    Support\Facades\DB,
    Support\Facades\Log,
    Support\Str,
};
use League\Flysystem\{
    Local\LocalFilesystemAdapter,
    Filesystem
};

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
        $fs = new Filesystem(new LocalFilesystemAdapter(database_path('seeders/Source')));
        $type = $this->getType();

        try {
            $json = $fs->read("$type.json");
        } catch (\Exception $e) {
            $message = "Warning: Seeder Source does not exist for $type";
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
}
