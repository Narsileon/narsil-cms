<?php

namespace App\Models\Sites;

#region USE

use App\Interfaces\IEnable;
use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 *
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
     * @var string
     */
    public const HANDLE = 'handle';
    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const LANGUAGE = 'language';
    /**
     * @var string
     */
    public const NAME = 'name';
    /**
     * @var string
     */
    public const PRIMARY = 'primary';

    /**
     * @var string
     */
    public const TABLE = 'sites';

    #endregion
}
