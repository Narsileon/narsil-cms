<?php

namespace Narsil\Cms\Models\Storages;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Traits\HasUuidPrimaryKey;
use Narsil\Cms\Traits\HasIdentifier;
use Narsil\Cms\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Asset extends Model
{
    use HasIdentifier;
    use HasTranslations;
    use HasUuidPrimaryKey;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->appends = [
            self::ATTRIBUTE_EXTENSION,
            self::ATTRIBUTE_FILENAME,
        ];

        $this->translatable = [
            self::ALT,
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
    final public const TABLE = 'assets';

    #region • COLUMNS

    /**
     * The name of the "alt" column.
     *
     * @var string
     */
    final public const ALT = 'alt';

    /**
     * The name of the "path" column.
     *
     * @var string
     */
    final public const PATH = 'path';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "extension" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_EXTENSION = 'extension';

    /**
     * The name of the "filename" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_FILENAME = 'filename';

    #endregion

    #endregion

    #region PROTECTED METHODS

    #region • ACCESSORS

    /**
     * Get the "extension" attribute.
     *
     * @return string
     */
    protected function extension(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return pathinfo($this->{self::PATH}, PATHINFO_EXTENSION);
            },
        );
    }

    /**
     * Get the "filename" attribute.
     *
     * @return string
     */
    protected function filename(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return pathinfo($this->{self::PATH}, PATHINFO_FILENAME);
            },
        );
    }

    #endregion

    #endregion
}
