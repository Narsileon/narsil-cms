<?php

namespace Narsil\Console\Commands;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MakeEntityNodeRelationCommand extends MakeModelCommand
{
    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    protected $description = 'Generate a entity node relation model.';

    /**
     * {@inheritDoc}
     */
    protected $signature = 'make:entity-node-relation
                            {name : The name of the model}
                            {template : The id of the template}';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getClass(string $name): string
    {
        return class_basename($this->template->EntityNodeRelationClass());
    }

    /**
     * {@inheritDoc}
     */
    protected function getStub(): string
    {
        return __dir__ . '/stubs/model.entity-node-relation.stub';
    }

    /**
     * {@inheritDoc}
     */
    protected function getTable(string $name): string
    {
        return $this->template->EntityNodeRelationTable();
    }

    #endregion
}
