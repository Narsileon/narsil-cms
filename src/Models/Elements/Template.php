<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Traits\Formatable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Template extends Model
{
    use Formatable;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_SECTIONS,
        ], $this->with);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "handle" column.
     */
    final public const HANDLE = 'handle';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';

    /**
     * @var string The name of the "sections" relation.
     */
    final public const RELATION_SECTIONS = 'sections';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'templates';

    #endregion

    #region RELATIONS

    /**
     * @return HasMany
     */
    public function sections(): HasMany
    {
        return $this
            ->hasMany(
                TemplateSection::class,
                TemplateSection::TEMPLATE_ID,
                self::ID,
            )
            ->orderBy(TemplateSection::POSITION);
    }

    #endregion
}
