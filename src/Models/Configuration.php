<?php

namespace Narsil\Models;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Configuration extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = [
            self::ID,
        ];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'configurations';

    #region • COLUMNS

    /**
     * The name of the "default language" column.
     *
     * @var string
     */
    final public const DEFAULT_LANGUAGE = 'default_language';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    #endregion

    #endregion
}
