# laravel-source-seeder
Laravel Seeder that allows for simple importing/exporting of database state from/to a given environment using a 
standardized workflow.

## Installation
Add the following snippet to your Application's `composer.json` in `repositories`
```
{
  "type": "vcs",
  "url": "git@github.com:bythepixel/laravel-source-seeder.git"
}
```

Next, run this command:
- `composer require bythepixel/laravel-source-seeder`

## Export Seeder Source Files (.json)
- `php artisan seeder:build {table?}`
- Generates .json files for all relevant tables (or as passed in by the table parameter)
- This command will typically be executed on a production environment to export "real" production data
- Once files have been generated they can be committed to the repository allowing new environments to be up to date
- If executed on a remote environment, `scp` is recommended to copy the json files
  - `scp -rp ./database/seeders/Source <user>@<public_ip>:/srv/www/database/seeders/Source`
  
  
## Example Seeder Class Implementation
```
<?php

namespace Database\Seeders;

use LaravelSourceSeeder\SourceSeeder;

class LocationSeeder extends SourceSeeder
{

}
```
