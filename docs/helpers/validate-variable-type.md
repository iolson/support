# Validate Variable Type

This helper is to add some more validation on specific variables if you need it. I was working with a Stripe [libary](https://github.com/cartalyst/stripe), that has some variables required to be certain types, and wanted to make sure that I was catching those before making the request to Stripe.

## Usage

```php
<?php

namespace App;

use IanOlson\Support\Helpers\ValidateVariableTypeHelper;

class Foo
{
	public function setAttributes($string, $int, array $array = [])
	{
		ValidateVariableTypeHelper::isString($string, 'string');
		ValidateVariableTypeHelper::isInt($int, 'int');
		ValidateVariableTypeHelper::isArray($array, 'array');
	}
}
```

## Methods

### throwException($message = '')

Throw `InvalidVariableTypeException` if a check returns false, and `$throw` is set to true on the method.

### isArray($check, $name, $throw = true)

Check if variable, `$check`, is an array. You'll pass in the `$name` is used so you can reference which was invalid when doing multiple checks. Set `$throw` to false, if you would rather return a `boolean` over throwing an exception.

### isBool($check, $name, $throw = true)

Check if variable, `$check`, is bool. You'll pass in the `$name` is used so you can reference which was invalid when doing multiple checks. Set `$throw` to false, if you would rather return a `boolean` over throwing an exception.

### isInt($check, $name, $throw = true)

Check if variable, `$check`, is an int. You'll pass in the `$name` is used so you can reference which was invalid when doing multiple checks. Set `$throw` to false, if you would rather return a `boolean` over throwing an exception.

### isNumeric($check, $name, $throw = true)

Check if variable, `$check`, is numeric. You'll pass in the `$name` is used so you can reference which was invalid when doing multiple checks. Set `$throw` to false, if you would rather return a `boolean` over throwing an exception.

### isString($check, $name, $throw = true)

Check if variable, `$check`, is a string. You'll pass in the `$name` is used so you can reference which was invalid when doing multiple checks. Set `$throw` to false, if you would rather return a `boolean` over throwing an exception.