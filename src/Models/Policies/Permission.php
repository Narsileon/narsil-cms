<?php

namespace Narsil\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Narsil\Observers\ModelObserver;
use Narsil\Support\SelectOption;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasRoles;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[ObservedBy([ModelObserver::class])]
class Permission extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasRoles;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->translatable = [
            self::LABEL,
        ];

        $this->mergeGuarded([
            self::ID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'permissions';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the permissions as select options.
     *
     * @return array<SelectOption>
     */
    public static function selectOptions(): array
    {
        return Cache::tags([self::TABLE])
            ->rememberForever('select_options', function ()
            {
                return self::all()
                    ->map(function (Permission $permission)
                    {
                        return (new SelectOption())
                            ->optionLabel($permission->{self::LABEL})
                            ->optionValue($permission->{self::ID});
                    })
                    ->all();
            });
    }

    #region • RELATIONSHIPS

    /**
     * {@inheritDoc}
     */
    final public function roles(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Role::class,
                RolePermission::TABLE,
                RolePermission::PERMISSION_ID,
                RolePermission::ROLE_ID,
            )
            ->using(RolePermission::class);
    }

    #endregion

    #endregion
}
