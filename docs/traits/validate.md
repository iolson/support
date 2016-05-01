# Validate Trait

This trait is for use in a service or another class that will handle business logic of requests from a form.

## Properties

### validationTypes

These are the valid options that we are able to pass to the [Laravel Validator](https://laravel.com/docs/5.2/validation). So when you are using the `addValidationOption` method, it will validate that you are using the correct validation types.

### messages

This will hold your custom messages that you want to pass to the validator for your form inputs.

### rules

This will hold your custom validation rules that you want to pass to the validator for your form inputs.

## Usage

```php
<?php

namespace App\Services\User;

use IanOlson\Support\Traits\ValidateTrait;

class UserService 
{
	use ValidateTrait;
	
	public function create(array $data)
	{
		// Add a validation rule.
		$this->addValidationOption('rules', 'title', 'required|max:255');
		
		// Add a validation message.
		$this->addValidationOption('messages', 'title.max', 'Title cannot be longer than 255 characters');
		
		// Validation will throw an exception if it fails.
		// Inside your controller you will need to do a try/catch.
		$this->validate($data);
	}
}
```

## Methods

### addValidationOption($type, $key, $rule)

This method is used to add validation options to either `type`, rules or messages. The `key` will be used as the name of the input field that is getting passed in the request. And `rule` can use any of the options provided by [Laravel](https://laravel.com/docs/5.2/validation#available-validation-rules). 

### removeValidationOption($type, $key)

This method is used to remove validation options to either `type`, rules or messages, by the `key`. The main usage is on an edit screen. Lets say we set up a global rule that slug must be unique. On an edit screen, if it stays the same and gets persisted this would cause an error. So you would say:

```php
if ($model->slug == Arr::get($data, 'slug')) {
	$this->removeValidationOption('rules', 'slug');
}

$this-validate($data);
```

### getValidationOptions($type)

This method is used to get all of the current validation options by the `type`, rules or messages.

### validate(array $data)

This method is used to validate data, mainly used within a Service type of class, that is called from a Controller.

### Service
```php
<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Lang;
use IanOlson\Support\Services\CrudServiceBase;
use IanOlson\Support\Traits\UpdateTrait;
use IanOlson\Support\Traits\ValidateTrait;

class UserServiceImpl extends CrudServiceBase implements UserService
{
	use ValidateTrait;
	
	public function create(array $data = [])
	{
		$this->addValidationOption('rules', 'title', 'required|unique');
		
		$this->validate($data);
	}
	
	public function update($id, array $data = [])
	{
		if (!$model = $this->find($id)) {
			$this->throwException(Lang::get('support.exceptions.model.find'));
		}
		
		if ($model->title == Arr::get($data, 'title')) {
			$this->removeValidationOption('rules', 'title');
			$this->addValidationOption('rules', 'title', 'required');
		}
		
		$this->validate($data);
		
		$this->updateAttributes($model, $data);
		
		$model->save();
		
		return $model;
	}
}
```

#### Controller 
```php
<?php

namespace App\Http\Controllers\UserController;

use App\Services\User\UserService;
use IanOlson\Support\Exceptions\ValidateException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
	/**
	 * @var UserService
	 */
	private $userService;
	
	public function __construct()
	{
		$this->userService = app()->make(UserService::class);
	}

	public function store(Request $request)
	{
		try {
			$user = $this->userService->create($request->all());
		} catch (ValidateException $e) {
			return redirect()->route('user.create')->withErrors($e->getErrors())->withInput();
		}
		
		// Do something on success.
	}
	
	public function update(Request $request, $id)
	{
		try {
			$user = $this->userService->update($id, $request->all());
		} catch (ValidateException $e) {
			return redirect()->route('user.edit')->withErrors($e->getErrors())->withInput();
		}
		
		// Do something on success.
	}
}
```

## Exceptions Thrown

### IanOlson\Support\Exceptions\ValidateException

_Need documentation_