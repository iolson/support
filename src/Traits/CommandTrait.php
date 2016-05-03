<?php

namespace IanOlson\Support\Traits;

use Illuminate\Support\Facades\File;
use IanOlson\Support\Helpers\ValidateVariableTypeHelper;
use Illuminate\Support\Str;

trait CommandTrait
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table;

    /**
     * Base path.
     *
     * @var string
     */
    protected $path;

    /**
     * Get model.
     *
     * @return string
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * Set model.
     *
     * @param string $model
     *
     * @return $this
     */
    protected function setModel($model)
    {
        ValidateVariableTypeHelper::isString($model, 'model');

        $this->model = $model;

        return $this;
    }

    /**
     * Get table.
     *
     * @return string
     */
    protected function getTable()
    {
        return $this->table;
    }

    /**
     * Set table.
     *
     * @param string $table
     *
     * @return $this
     */
    protected function setTable($table)
    {
        ValidateVariableTypeHelper::isString($table, 'table');

        $this->table = $table;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    protected function getPath()
    {
        return $this->path;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    protected function setPath($path)
    {
        ValidateVariableTypeHelper::isString($path, 'path');

        $this->path = $path;

        return $this;
    }

    /**
     * Create directory.
     *
     * @param string $directory
     */
    protected function createDirectory($directory)
    {
        File::makeDirectory("{$this->getPath()}/{$directory}");

        return;
    }

    /**
     * Get content from stub and update.
     *
     * @param string $type
     *
     * @return string
     */
    protected function getContent($type)
    {
        $stub = self::COMMAND_DIRECTORY . self::STUB_DIRECTORY . "{$type}.stub";

        if (isset($this->model) && !is_null($this->getModel())) {
            $stubContent = str_replace('{{model}}', $this->getModel(), File::get($stub));
            $stubContent = str_replace('{{model_lower}}', Str::camel($this->getModel()), $stubContent);

            if (isset($this->table) && !is_null($this->getTable())) {
                $stubContent = str_replace('{{table}}', $this->getTable(), $stubContent);
            }
        }

        $content = (isset($stubContent)) ? $stubContent : null;

        if (is_null($content)) {
            $content = File::get($stub);
        }

        return $content;
    }

    /**
     * Write the file to the filesystem.
     *
     * @param string $content
     * @param string $directory
     * @param string $fileName
     * @param null   $end
     * @param null   $ext
     */
    protected function writeFile($content, $directory, $fileName, $end = null, $ext = null)
    {
        if (is_null($ext)) {
            $ext = '.php';
        }

        if (!is_null($directory)) {
            $fullPath = "{$this->getPath()}/{$directory}/{$fileName}{$end}{$ext}";
        } else {
            $fullPath = "{$this->getPath()}/{$fileName}{$end}{$ext}";
        }

        File::put($fullPath, $content);

        return;
    }
}
