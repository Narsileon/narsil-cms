<?php

namespace Narsil\Cms\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Narsil\Base\Observers\ModelObserver;
use Narsil\Base\Traits\AuditLoggable;
use Narsil\Base\Traits\Blameable;
use Narsil\Cms\Support\SelectOption;
use Narsil\Cms\Traits\HasDatetimes;
use Narsil\Cms\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[ObservedBy([ModelObserver::class])]
class Template extends Model
{
    use Blameable;
    use AuditLoggable;
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

    /**
     * The name of the "table name" column.
     *
     * @var string
     */
    final public const TABLE_NAME = 'table_name';

    #endregion

    #region • COUNTS

    /**
     * The name of the "tabs" count.
     *
     * @var string
     */
    final public const COUNT_TABS = 'tabs_count';

    #endregion

    #region • RELATIONS

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

    /**
     * Get the class of the entity model.
     *
     * @return string
     */
    public function entityClass(): string
    {
        $namespace = $this->entityNamespace();

        $class = Str::studly(Str::singular($this->{self::TABLE_NAME}));

        return "$namespace\\$class";
    }

    /**
     * Get the namespace of the entity models.
     *
     * @return string
     */
    public function entityNamespace(): string
    {
        $namespace = Str::studly(Str::plural($this->{self::TABLE_NAME}));

        return "App\\Models\\$namespace";
    }

    /**
     * Get the class of the entity node model.
     *
     * @return string
     */
    public function entityNodeClass(): string
    {
        return $this->entityClass() . 'Node';
    }

    /**
     * Get the class of the entity node relation model.
     *
     * @return string
     */
    public function entityNodeRelationClass(): string
    {
        return $this->entityClass() . 'NodeRelation';
    }

    /**
     * Get the table of the entity model.
     *
     * @return string
     */
    public function entityTable(): string
    {
        $table = Str::snake(Str::plural($this->{self::TABLE_NAME}));

        return $table;
    }

    /**
     * Get the table of the entity node model.
     *
     * @return string
     */
    public function entityNodeTable(): string
    {
        $table = Str::snake(Str::singular($this->{self::TABLE_NAME}));

        return $table . '_nodes';
    }

    /**
     * Get the table of the entity node relation model.
     *
     * @return string
     */
    public function entityNodeRelationTable(): string
    {
        $table = Str::snake(Str::singular($this->{self::TABLE_NAME}));

        return $table . '_node_relation';
    }

    #region • RELATIONSHIPS

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

    #endregion
}
