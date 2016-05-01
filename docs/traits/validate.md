# Validate Trait

This trait is for use in a repository or another class that will handle business logic of requests from a form.

## Properties

### validationTypes

_Need documentation_

### messages

This will hold your custom messages that you want to pass to the validator for your form inputs.

### rules

This will hold your custom validation rules that you want to pass to the validator for your form inputs.

## Usage

```php
<?php

namespace App\Repositories;

use IanOlson\Support\Traits\ValidateTrait;

class Foo
{
	use ValidateTrait;
	
	public function create(array $data)
	{
		// Add a validation rule.
		$this->addValidationOption('rules', 'title', 'required|max:255');
		
		// Add a validation message.
		$this->addValidationOption('messages', 'title.max', 'Title cannot be longer than 255 characters');
		
		// Validation will throw an exception.
		// Inside your controller you will need to do a try/catch.
		$this->validate($data);
	}
}
```

## Methods

### addValidationOption($type, $key, $rule)

_Need documentation_

### removeValidationOption($type, $key)

_Need documentation_

### getValidationOptions($type)

_Need documentation_

### validate(array $data)

_Need documentation_

## Exceptions Thrown

### IanOlson\Support\Exceptions\ValidateException

_Need documentation_