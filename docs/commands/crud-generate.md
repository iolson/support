# CRUD Generator

When creating projects, I tend to follow a `Service` level approach. It used to be Contracts (interfaces) and Repositories, but things would just get messy for myself. After working on a couple of Java projects, it seemed this approach makes a lot of sense for my bigger applications.

When building out your application you can get started pretty quickly by just running a simple command:

```bash
$ php artisan support:make:crud {model}
```

Files that get generated when the command is executed:

- `app/Exceptions/ModelException.php`
- `app/Http/Controllers/ModelController.php`
- `app/Models/Model.php`
- `app/Services/Model/ModelService.php`
- `app/Services/Model/ModelServiceImpl.php`
- `database/migrations/create_model_table.php`

I tend to like a more detailed Exception being thrown when working with Models, so I generate a new Model Exception that by default is used in the `CrudServiceBase` class.

One thing you'll need to be sure to do, is to add the binding of the service to the service implementation, more information can be found [here](https://laravel.com/docs/5.2/container#binding).

```php
$this->app->bind('App\Services\Model\ModelService', 'App\Services\Model\ModelServiceImpl');
```

This will allow the generated Controllers to resolve the implemntation inside their constructor, more information can be found [here](https://laravel.com/docs/5.2/container#resolving).