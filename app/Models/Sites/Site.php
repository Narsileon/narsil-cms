<?php

namespace App\Models\Sites;

#region USE

use App\Interfaces\IEnable;
use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Site extends Model implements IEnable
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "handle" column.
     */
    public const HANDLE = 'handle';
    /**
     * @var string The name of the "id" column.
     */
    public const ID = 'id';
    /**
     * @var string The name of the "language" column.
     */
    public const LANGUAGE = 'language';
    /**
     * @var string The name of the "name" column.
     */
    public const NAME = 'name';
    /**
     * @var string The name of the "primary" column.
     */
    public const PRIMARY = 'primary';

    /**
     * @var string The name of the "sites" table.
     */
    public const TABLE = 'sites';

    #endregion
}
