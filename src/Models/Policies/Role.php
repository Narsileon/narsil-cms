<?php

namespace Narsil\Cms\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Narsil\Cms\Models\User;
use Narsil\Cms\Observers\ModelObserver;
use Narsil\Cms\Support\SelectOption;
use Narsil\Cms\Traits\Blameable;
use Narsil\Cms\Traits\HasAuditLogs;
use Narsil\Cms\Traits\HasDatetimes;
use Narsil\Cms\Traits\Policies\HasPermissions;
use Narsil\Cms\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[ObservedBy([ModelObserver::class])]
class Role extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasPermissions;
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
    final public const TABLE = 'roles';

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

    #region • COUNTS

    /**
     * The name of the "users" count.
     *
     * @var string
     */
    final public const COUNT_USERS = 'users_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "users" relation.
     *
     * @var string
     */
    final public const RELATION_USERS = 'users';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the roles as select options.
     *
     * @return array<SelectOption>
     */
    public static function selectOptions(): array
    {
        return Cache::tags([self::TABLE])
            ->rememberForever('select_options', function ()
            {
                return self::all()
                    ->map(function (Role $role)
                    {
                        return (new SelectOption())
                            ->optionLabel($role->{self::LABEL})
                            ->optionValue($role->{self::ID});
                    })
                    ->all();
            });
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated permissions.
     *
     * @return BelongsToMany
     */
    final public function permissions(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Permission::class,
                RolePermission::TABLE,
                RolePermission::ROLE_ID,
                RolePermission::PERMISSION_ID,
            )
            ->using(RolePermission::class);
    }

    /**
     * Get the associated users.
     *
     * @return BelongsToMany
     */
    final public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                User::class,
                UserRole::TABLE,
                UserRole::ROLE_ID,
                UserRole::USER_ID,
            )
            ->using(UserRole::class);
    }

    #endregion

    #endregion
}
