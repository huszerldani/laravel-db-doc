# Laravel Database Documentation generator from existing database

With this package you can easily create a markdown database documentation

## Installing

```bash
composer require huszerldani/laravel-db-doc
```
<br/>

Before generating your documentation, please check the **DB_DATABASE** env variable

## Publishing config and view file

You can modify the configuration file or the view file to generate unique documentation.

To copy the config file (**db_doc.php**) and the view file (**views/vendor/db_doc/database_doc.blade.php**), please use the vendor publish artisan command:
```bash
php artisan vendor:publish
```


## Generating documentation

```bash
php artisan db-doc:generate
```
