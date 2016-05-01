<?php

namespace IanOlson\Support\Services;

use Illuminate\Support\Facades\Lang;
use IanOlson\Support\Traits\ServiceTrait;
use IanOlson\Support\Traits\UpdateTrait;
use IanOlson\Support\Traits\ValidateTrait;

abstract class CrudServiceBase
{
    use ServiceTrait;
    use UpdateTrait;
    use ValidateTrait;

    /**
     * Construct.
     *
     * @param null $model
     */
    public function __construct($model = null)
    {
        if (isset($model)) {
            $this->setModel($model);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function index()
    {
        return $this->createModel()->newQuery()->get();
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return $this->createModel()->newQuery()->where('id', $id)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data = [])
    {
        $this->validate($data);

        $model = $this->createModel();

        $this->updateAttributes($model, $data);

        $model->save();

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $data = [])
    {
        if (!$model = $this->find($id)) {
            $this->throwException(Lang::get('support.exceptions.model.find'));
        }

        $this->validate($data);

        $this->updateAttributes($model, $data);

        $model->save();

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$model = $this->find($id)) {
            $this->throwException(Lang::get('support.exceptions.model.find'));
        }

        $model->delete();

        return true;
    }
}
