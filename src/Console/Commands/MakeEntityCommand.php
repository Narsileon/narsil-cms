<?php

namespace Narsil\Console\Commands;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MakeEntityCommand extends MakeModelCommand
{
    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    protected $description = 'Generate a entity model.';

    /**
     * {@inheritDoc}
     */
    protected $signature = 'make:entity
                            {name : The name of the model}
                            {template : The id of the template}';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getClass(string $name): string
    {
        return class_basename($this->template->entityClass());
    }

    /**
     * {@inheritDoc}
     */
    protected function getStub(): string
    {
        return __dir__ . '/stubs/model.entity.stub';
    }

    /**
     * {@inheritDoc}
     */
    protected function getTable(string $name): string
    {
        return $this->template->entityTable();
    }


    #endregion
}
