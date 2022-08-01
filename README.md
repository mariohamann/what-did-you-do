## what-did-you-do

### Prerequisites
You need PHP, Composer, Node.js and pnpm Follow those guideline https://laravel.com/docs/9.x/valet#installation. From that on PHP and Composer should work.

### Installation
- `cd` in the repo
- `php composer install` (installs all PHP packages)
- `touch database/database.sqlite` (creates an empty local database)
- duplicate `.env.example` and rename it to `.env`
- `php artisan migrate:fresh --seed` (to setup the database)
- `pnpm i` (installs all node packages – make sure to have pnpm installed)
- Link your local repo to valet with `valet link`. From that on the website should be available from `what-did-you-do.test`
- Update your `.env`: `APP_URL=http://what-did-you-do.test/`
- run it with `pnpm run dev`
- Test users are already setup: `test1@example.com` and `test2@example.com` with password `!password`

### After updates
- run `pnpm i` and `composer install`
- run `php artisan migrate` to update the database or `php artisan migrate:refresh --seed` to reset your local database to the default one (the latter is often preferrable)


------------
## Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.
