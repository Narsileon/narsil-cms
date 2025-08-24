<?php

namespace Narsil\Traits;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasTableName
{
    #region PROPERTIES

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected static string $tableName = '';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return static::$tableName;
    }

    /**
     * @return void
     */
    public static function setTableName(string $tableName): void
    {
        static::$tableName = $tableName;
    }

    #endregion
}
