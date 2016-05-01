<?php

namespace IanOlson\Support\Traits;

trait ServiceTrait
{
    /**
     * Full namespace of exception.
     *
     * @var string
     */
    protected $exception;

    /**
     * Full namespace of model.
     *
     * @var string
     */
    protected $model;

    /**
     * Create a new instance of the model.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createModel(array $data = [])
    {
        $class = '\\' . ltrim($this->getModel(), '\\');

        return new $class($data);
    }

    /**
     * Returns the model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Runtime override of the model.
     *
     * @param string $model
     *
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Returns the exception.
     *
     * @return string
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Runtime override of the exception.
     *
     * @param string $exception
     *
     * @return $this
     */
    public function setException($exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Throw model exception.
     *
     * @param string $message
     */
    public function throwException($message)
    {
        $exception = '\\' . ltrim($this->getException(), '\\');

        throw new $exception($message);
    }
}
