<?php

namespace Narsil\Cms\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Cache;
use Narsil\Base\Models\Policies\Role as BaseRole;
use Narsil\Cms\Observers\ModelObserver;
use Narsil\Cms\Support\SelectOption;
use Narsil\Cms\Traits\HasDatetimes;
use Narsil\Cms\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[ObservedBy([ModelObserver::class])]
class Role extends BaseRole
{
    use HasDatetimes;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->translatable = [
            self::LABEL,
        ];

        parent::__construct($attributes);
    }

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

    #endregion
}
