<?php

namespace Narsil\Models\Structures;

#region USE

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Narsil\Models\Entities\Entity;
use Narsil\Observers\ModelObserver;
use Narsil\Support\SelectOption;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[ObservedBy([ModelObserver::class])]
class Template extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
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

        $this->translatable = [
            self::SINGULAR,
            self::PLURAL,
        ];

        $this->with = [
            self::RELATION_TABS,
        ];

        parent::__construct($attributes);

        if ($tabs = Arr::get($attributes, self::RELATION_TABS))
        {
            $this->setRelation(self::RELATION_TABS, collect($tabs));
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'templates';

    #region • COLUMNS

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "plural" column.
     *
     * @var string
     */
    final public const PLURAL = 'plural';

    /**
     * The name of the "singular" column.
     *
     * @var string
     */
    final public const SINGULAR = 'singular';

    #endregion

    #region • COUNTS

    /**
     * The name of the "entities" count.
     *
     * @var string
     */
    final public const COUNT_ENTITIES = 'entities_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "entities" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITIES = 'entities';

    /**
     * The name of the "tabs" relation.
     *
     * @var string
     */
    final public const RELATION_TABS = 'tabs';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the templates as select options.
     *
     * @return array<SelectOption>
     */
    public static function selectOptions(): array
    {
        return Cache::tags([self::TABLE])
            ->rememberForever('select_options', function ()
            {
                return self::all()
                    ->map(function (Template $template)
                    {
                        return (new SelectOption())
                            ->optionLabel($template->{Template::PLURAL})
                            ->optionValue((string)$template->{Template::ID});
                    })
                    ->all();
            });
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated entities.
     *
     * @return HasMany
     */
    final public function entities(): HasMany
    {
        return $this
            ->hasMany(
                Entity::class,
                Entity::TEMPLATE_ID,
                self::ID,
            );
    }

    /**
     * Get the associated tabs.
     *
     * @return HasMany
     */
    final public function tabs(): HasMany
    {
        return $this
            ->hasMany(
                TemplateTab::class,
                TemplateTab::TEMPLATE_ID,
                self::ID,
            )
            ->orderBy(TemplateTab::POSITION);
    }

    #endregion

    #region • SCOPES

    /**
     * @param Builder $query
     * @param integer|string $value
     *
     * @return void
     */
    #[Scope]
    protected function byIdOrHandle(Builder $query, int|string $value): void
    {
        if (is_numeric($value))
        {
            $query->where(self::ID, $value);
        }
        else
        {
            $query->where(self::HANDLE, $value);
        }
    }

    #endregion

    #endregion
}
