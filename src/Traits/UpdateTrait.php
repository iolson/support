<?php

namespace IanOlson\Support\Traits;

use Illuminate\Support\Arr;

trait UpdateTrait
{
    /**
     * Non-required attributes.
     *
     * @var array
     */
    protected $nonRequiredAttributes = [];

    /**
     * Add a non-required attribute.
     *
     * This method is used for adding attributes that can be left null or blank and should update the model
     * accordingly. For example a 'subscribedToNewsletter' column has a boolean. If this returns false then it will be
     * missed on the empty($value) check inside updateAttributes() method. This allows this to be set.
     *
     * @param string $attribute
     *
     * @return array
     */
    protected function addNonRequiredAttribute($attribute)
    {
        $this->nonRequiredAttributes = Arr::add($this->nonRequiredAttributes, $attribute, $attribute);

        return $this->nonRequiredAttributes;
    }

    /**
     * Remove a non-required attribute.
     *
     * @param string $attribute
     *
     * @return array
     */
    protected function removeNonRequiredAttribute($attribute)
    {
        Arr::forget($this->nonRequiredAttributes, $attribute);

        return $this->nonRequiredAttributes;
    }

    /**
     * Get non-required attributes.
     *
     * @return array
     */
    protected function getNonRequiredAttributes()
    {
        return $this->nonRequiredAttributes;
    }

    /**
     * Update attributes.
     *
     * @param $model
     * @param array $data
     */
    protected function updateAttributes(&$model, array &$data)
    {
        if (empty($data)) {
            return;
        }

        $massAssign = $model->getFillable();

        foreach ($data as $attribute => $value) {
            if (!in_array($attribute, $massAssign)) {
                continue;
            }

            if (in_array($attribute, $this->getNonRequiredAttributes())) {
                $model->$attribute = $value;
            }

            if (empty($value)) {
                continue;
            }

            if ($attribute == 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }

            $model->$attribute = $value;
        }

        return;
    }
}
