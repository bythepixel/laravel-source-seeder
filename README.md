# btp-laravel-package-base
A base repository template for creating BTP Laravel Packages.

## Overview
This helps us create internal BTP packages that follow a standard structure, making creating them easier without 
needing to re-read the Laravel Docs and start from scratch :D

### Laravel Docs
Laravel Package Development: https://laravel.com/docs/8.x/packages

### Example Package Implementation
Example BTP Laravel Package: https://github.com/bythepixel/nova-page-elements

## Implementation
To implement this template for a new Package, after cloning you will need to make some changes:
- `src/PackageNameServiceProvider.php`
  - See `PackageNameServiceProvider` Class DocBlock for instructions
  - Uncomment Relevant Package Publish Steps in `PackageNameServiceProvider::boot`
    - Each "type" of Publishing Step has a comment that describes what it does.
    - If your Package does not include Migrations, then you can delete the `// Load Package Migrations`, for example
    - If your Package does include Migrations, then you should uncomment the logic under `// Load Package Migrations`
- `composer.json`
  - PSR-4 Autoload Configuration
  - Extra Laravel Provider Namespace
  - All Package Metadata (ex: `name`, `description`, `homepage`, etc.)
  - Change `require` Configuration to include all of your Package's Composer Dependencies

You will also need to go through each of the directories in this template and determine which will be used for your
specific Package. Any directories that ONLY contain `empty.txt` once you have added your Package Code can be deleted.

These `empty.txt` files only exist to show intended Package Directory Structure when using various Package Components.

All `empty.txt` files should be deleted in your Package.