<?php

namespace Narsil\Cms\Models\Storages;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Narsil\Cms\Traits\HasIdentifier;
use Narsil\Cms\Traits\HasTranslations;
use Narsil\Cms\Traits\HasUuidKey;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Media extends Model
{
    use HasIdentifier;
    use HasTranslations;
    use HasUuidKey;

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
            self::ATTRIBUTE_SOURCE,
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
    final public const TABLE = 'media';

    #region • COLUMNS

    /**
     * The name of the "alt" column.
     *
     * @var string
     */
    final public const ALT = 'alt';

    /**
     * The name of the "disk" column.
     *
     * @var string
     */
    final public const DISK = 'disk';

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

    /**
     * The name of the "src" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_SOURCE = 'src';

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

    /**
     * Get the "src" attribute.
     *
     * @return string
     */
    protected function src(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return Storage::url($this->{self::DISK} . '/' . $this->{self::PATH});
            },
        );
    }

    #endregion

    #endregion
}
