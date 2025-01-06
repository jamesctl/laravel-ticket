<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Install the ticket package
- Run: composer require "globit/laravel-ticket @dev"

## Set up the package following the structure after installed ticket

### Migrations
Copy all migration files from "vendor/globit/laravel-ticket/database/migrations" folder to your application folder "app/database/migrations".

Run: php artisan migrate

### Models

Copy all model files from "vendor/globit/laravel-ticket/app/Models" folder to your application folder "app/Models".

### Controllers
Copy the controller files from "vendor/globit/laravel-ticket/app/Http/Controllers/Admin/TicketController.php" to your application folder "app/Http/Controllers/Admin".

### Services

Copy the controller files from "vendor/globit/laravel-ticket/app/Services" folder to your application folder "app/Services".

### Routes

Copy the ticket.php file from "vendor/globit/laravel-ticket/routes/admin/ticket.php" to your application folder "routes/admin/ticket.php".

- Add the line include('admin/ticket.php'); in your admin route file "routes/admin.php"

### Resources

Copy all files from "vendor/globit/laravel-ticket/resources/views/admin/general" folder to your application folder "resources/views/admin/general" folder

Copy all files from "vendor/globit/laravel-ticket/resources/views/admin/ticket" folder to your application folder "resources/views/admin/ticket" folder

Copy email folder, vendor folder from "vendor/globit/laravel-ticket/resources/views/" to your application folder "resources/views/" folder

### Configs

Copy imap.php, mail.php file from "vendor/globit/laravel-ticket/config" folder to your application folder "config".

### Reference folders

Copy folder "vendor/globit/laravel-ticket/lang" to your application folder "lang".

Copy child folders from "vendor/globit/laravel-ticket/public/themes/" folder to your application folder "public/themes/".

Copy all files from "vendor/globit/laravel-ticket/app/Mail" to your application folder "app/Mail".

### ENV variables
Add these variables to your .env file

- IMAP_HOST=
- IMAP_PORT=
- IMAP_ENCRYPTION=ssl
- IMAP_VALIDATE_CERT=true
- IMAP_USERNAME=
- IMAP_PASSWORD=
- IMAP_DEFAULT_ACCOUNT=default
- IMAP_PROTOCOL=imap

- MAIL_MAILER=smtp
- MAIL_HOST=
- MAIL_PORT=
- MAIL_USERNAME=
- MAIL_PASSWORD=
- MAIL_ENCRYPTION=ssl
- MAIL_FROM_ADDRESS=""
- MAIL_FROM_NAME="${APP_NAME}"


### Access ticket via these endpoints

- {domain}/admin/ticket

<!--
## About Laravel

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

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

-->
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
