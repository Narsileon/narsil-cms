<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait Templateable
{
    #region CONSTANTS

    /**
     * The name of the "table name" column.
     *
     * @var string
     */
    final public const TABLE_NAME = 'table_name';

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the class of the entity model.
     *
     * @return string
     */
    public function entityClass(): string
    {
        $namespace = $this->entityNamespace();

        $class = Str::studly(Str::singular($this->{self::TABLE_NAME}));

        return "$namespace\\$class";
    }

    /**
     * Get the namespace of the entity models.
     *
     * @return string
     */
    public function entityNamespace(): string
    {
        $namespace = Str::studly(Str::plural($this->{self::TABLE_NAME}));

        return "App\\Models\\$namespace";
    }

    /**
     * Get the class of the entity node model.
     *
     * @return string
     */
    public function entityNodeClass(): string
    {
        return $this->entityClass() . 'Node';
    }

    /**
     * Get the class of the entity node relation model.
     *
     * @return string
     */
    public function entityNodeRelationClass(): string
    {
        return $this->entityClass() . 'NodeRelation';
    }

    /**
     * Get the table of the entity model.
     *
     * @return string
     */
    public function entityTable(): string
    {
        $table = Str::snake(Str::plural($this->{self::TABLE_NAME}));

        return $table;
    }

    /**
     * Get the table of the entity node model.
     *
     * @return string
     */
    public function entityNodeTable(): string
    {
        $table = Str::snake(Str::singular($this->{self::TABLE_NAME}));

        return $table . '_nodes';
    }

    /**
     * Get the table of the entity node relation model.
     *
     * @return string
     */
    public function entityNodeRelationTable(): string
    {
        $table = Str::snake(Str::singular($this->{self::TABLE_NAME}));

        return $table . '_node_relation';
    }

    #endregion
}
