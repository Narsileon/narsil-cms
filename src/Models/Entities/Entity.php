<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Narsil\Policies\EntityPolicy;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasRevisions;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[UsePolicy(EntityPolicy::class)]
class Entity extends Model
{
    use Blameable;
    use HasDatetimes;
    use HasUuids;
    use HasRevisions;

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

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function maxRevisions(): ?int
    {
        return null;
    }

    #endregion
}
