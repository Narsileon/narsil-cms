<?php

namespace Narsil\Cms\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Observers\ModelObserver;
use Narsil\Base\Traits\AuditLoggable;
use Narsil\Base\Traits\Blameable;
use Narsil\Base\Traits\HasDatetimes;
use Narsil\Base\Traits\HasTranslations;
use Narsil\Cms\Database\Factories\HeaderFactory;
use Narsil\Cms\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[ObservedBy(ModelObserver::class)]
#[UseFactory(HeaderFactory::class)]
class Header extends Model
{
    use Blameable;
    use AuditLoggable;
    use HasDatetimes;
    use HasFactory;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

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
    final public const TABLE = 'headers';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "logo" column.
     *
     * @var string
     */
    final public const LOGO = 'logo';

    /**
     * The name of the "slug" column.
     *
     * @var string
     */
    final public const SLUG = 'slug';

    #endregion

    #region • COUNTS

    /**
     * The name of the "websites" count.
     *
     * @var string
     */
    final public const COUNT_WEBSITES = 'websites_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "websites" relation.
     *
     * @var string
     */
    final public const RELATION_WEBSITES = 'websites';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the headers as options.
     *
     * @return OptionData[]
     */
    public static function options(): array
    {
        return Cache::tags([self::TABLE])
            ->rememberForever('options', function ()
            {
                return self::all()
                    ->map(function (Header $header)
                    {
                        return new OptionData(
                            label: $header->{self::SLUG},
                            value: $header->{self::ID},
                        );
                    })
                    ->all();
            });
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated websites.
     *
     * @return HasMany
     */
    final public function websites(): HasMany
    {
        return $this
            ->hasMany(
                Site::class,
                Site::HEADER_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
