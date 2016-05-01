<?php

namespace IanOlson\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use IanOlson\Support\Exceptions\ValidateException;

trait ValidateTrait
{
    /**
     * Validation types.
     *
     * @var array
     */
    protected $validationTypes = ['rules', 'messages'];

    /**
     * Custom validation options for messages and rules used for validation.
     *
     * @var array
     */
    protected $validationOptions = [];

    /**
     * Check validation types.
     *
     * @param string $type
     *
     * @throws ValidateException
     */
    protected function checkValidationTypes($type)
    {
        if (!in_array($type, $this->validationTypes)) {
            throw new ValidateException(Lang::get('support.exceptions.validate.type'));
        }
    }

    /**
     * Add validation option.
     *
     * @param string $type
     * @param string $key
     * @param string $value
     *
     * @throws ValidateException
     *
     * @return array
     */
    protected function addValidationOption($type, $key, $value)
    {
        $this->checkValidationTypes($type);

        $this->validationOptions = Arr::add($this->validationOptions, "{$type}.{$key}", $value);

        return $this->validationOptions;
    }

    /**
     * Remove validation option.
     *
     * @param string $type
     * @param string $key
     *
     * @throws ValidateException
     *
     * @return array
     */
    protected function removeValidationOption($type, $key)
    {
        $this->checkValidationTypes($type);

        Arr::forget($this->validationOptions, "{$type}.{$key}");

        return $this->validationOptions;
    }

    /**
     * Get validation options by type.
     *
     * @param string $type
     *
     * @throws ValidateException
     *
     * @return mixed
     */
    protected function getValidationOptions($type)
    {
        $this->checkValidationTypes($type);

        return Arr::get($this->validationOptions, $type);
    }

    /**
     * Validate the form data.
     *
     * @param array       $data    An array of data to validate against the rules.
     * @param null|string $message Message to be thrown with the custom exception.
     *
     * @throws ValidateException
     *
     * @return boolean
     */
    protected function validate(array $data, $message = null)
    {
        $validator = Validator::make(
            $data,
            $this->getValidationOptions('rules'),
            $this->getValidationOptions('messages')
        );

        if ($validator->fails()) {
            if (is_null($message)) {
                $message = Lang::get('support.exceptions.validate.fail');
            }

            throw new ValidateException($message, $validator);
        }

        return true;
    }
}
