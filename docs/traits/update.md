# Update Trait

This trait is for use in a service or another class that deals with updating Eloquent models.

## Properties

### nonRequiredAttributes

This will hold your non-required attributes for models.

## Usage

```php
<?php

namespace App\Services\User;

use App\Models\User;
use IanOlson\Support\Traits\UpdateTrait;

class UserServiceImpl extends UserService
{
	public function create(array $data = [])
	{
		$this->validate($data);
		
		$model = User::create();
		
		$this->updateAttributes($model, $data);
		
		$model->save();
		
		return $model;
	}
}
```

## Methods

### addNonRequiredAttribute($attribute)

This method is used for adding attributes that can be left null or blank and should update the model accordingly. For example a 'subscribed_to_newsletter' column has a boolean. If this returns false then it will be missed on the `empty($value)` check inside `updateAttributes()` method. This allows this to be set.

### removeNonRequiredAttribute($attribute)

Remove a non-required attribute.

### getNonRequiredAttributes()

Get a non-required attributes.

### updateAttributes(&$model, array &$data = [])

Update attributes on a model. This will call the `$model` method of `getFillable()` which will get the mass assignable attributes of the model. Loop through `$data` and assign the attributes to the `$model` and return it.