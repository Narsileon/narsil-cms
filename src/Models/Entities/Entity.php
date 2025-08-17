<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Narsil\Policies\EntityPolicy;
use Narsil\Traits\HasDatetimes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[UsePolicy(EntityPolicy::class)]
class Entity extends Model
{
    use HasDatetimes;
    use HasUuids;
    use SoftDeletes;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::$associatedTable;

        $this->primaryKey = self::UUID;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "deleted at" column.
     */
    final public const DELETED_AT = 'deleted_at';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "uuid" column.
     */
    final public const UUID = 'uuid';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'entities';

    #endregion

    #region PROPERTIES

    /**
     * The table associated with the model.
     */
    public static string $associatedTable = self::TABLE;

    #endregion
}
