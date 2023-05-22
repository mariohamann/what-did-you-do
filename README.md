## what-did-you-do

### Prerequisites

You need PHP, Composer, Node.js and pnpm Follow those guideline https://laravel.com/docs/9.x/valet#installation. From that on PHP and Composer should work.

### Installation

-   `cd` in the repo
-   `php composer install` (installs all PHP packages)
-   `php artisan storage:link` (creates a symlink to the storage folder, needed for JSON)
-   `touch database/database.sqlite` (creates an empty local database)
-   duplicate `.env.example` and rename it to `.env`
-   `php artisan migrate:fresh --seed` (to setup the database)
-   `pnpm i` (installs all node packages – make sure to have pnpm installed)
-   Link your local repo to valet with `valet link`. From that on the website should be available from `what-did-you-do.test`
-   Update your `.env`: `APP_URL=http://what-did-you-do.test/`
-   run it with `pnpm run dev`
-   Test users are already setup: `test1@example.com` and `test2@example.com` with password `!password`

### After updates

-   run `pnpm i` and `composer install`
-   run `php artisan migrate` to update the database or `php artisan migrate:fresh --seed` to reset your local database to the default one (the latter is often preferrable)

---

## The JSON File

-   Make sure to run `php artisan storage:link` to create a symlink to the storage folder, needed for JSON
-   If you already have actions in your database, you can create the JSON with `php artisan app:create-actions-json`, otherwise it will be created automatically when you run `php artisan migrate:fresh --seed`
-   The JSON file is located in `storage/app/public/actions.json`
