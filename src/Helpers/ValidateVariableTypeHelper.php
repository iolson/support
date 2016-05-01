<?php

namespace IanOlson\Support\Helpers;

use IanOlson\Support\Exceptions\InvalidVariableTypeException;

class ValidateVariableTypeHelper
{
    const INVALID_VARIABLE_ARRAY = 'The %s variable is not an array.';
    const INVALID_VARIABLE_BOOL = 'The %s variable is not a bool.';
    const INVALID_VARIABLE_INT = 'The %s variable is not an int.';
    const INVALID_VARIABLE_NUMERIC = 'The %s variable is not numeric.';
    const INVALID_VARIABLE_STRING = 'The %s variable is not a string.';

    /**
     * Throw exception.
     *
     * @param string $message
     *
     * @throws InvalidVariableTypeException
     */
    private static function throwException($message = '')
    {
        throw new InvalidVariableTypeException($message);
    }

    /**
     * Check if variable is an array.
     *
     * @param mixed  $check
     * @param string $name
     *
     * @throws InvalidVariableTypeException
     *
     * @return bool
     */
    public static function isArray($check, $name, $throw = true)
    {
        if (!is_array($check)) {
            if ($throw) {
                self::throwException(sprintf(self::INVALID_VARIABLE_ARRAY, $name));
            }

            return false;
        }

        return true;
    }

    /**
     * Check if variable is a bool.
     *
     * @param mixed  $check
     * @param string $name
     *
     * @throws InvalidVariableTypeException
     *
     * @return bool
     */
    public static function isBool($check, $name, $throw = true)
    {
        if (!is_bool($check)) {
            if ($throw) {
                self::throwException(sprintf(self::INVALID_VARIABLE_BOOL, $name));
            }

            return false;
        }

        return true;
    }

    /**
     * Check if variable is an int.
     *
     * @param mixed  $check
     * @param string $name
     *
     * @throws InvalidVariableTypeException
     *
     * @return bool
     */
    public static function isInt($check, $name, $throw = true)
    {
        if (!is_int($check)) {
            if ($throw) {
                self::throwException(sprintf(self::INVALID_VARIABLE_INT, $name));
            }

            return false;
        }

        return true;
    }

    /**
     * Check if variable is numeric.
     *
     * @param mixed  $check
     * @param string $name
     *
     * @throws InvalidVariableTypeException
     *
     * @return bool
     */
    public static function isNumeric($check, $name, $throw = true)
    {
        if (!is_numeric($check)) {
            if ($throw) {
                self::throwException(sprintf(self::INVALID_VARIABLE_NUMERIC, $name));
            }

            return false;
        }

        return true;
    }

    /**
     * Check if variable is a string.
     *
     * @param mixed  $check
     * @param string $name
     *
     * @throws InvalidVariableTypeException
     *
     * @return bool
     */
    public static function isString($check, $name, $throw = true)
    {
        if (!is_string($check)) {
            if ($throw) {
                self::throwException(sprintf(self::INVALID_VARIABLE_STRING, $name));
            }

            return false;
        }

        return true;
    }
}
