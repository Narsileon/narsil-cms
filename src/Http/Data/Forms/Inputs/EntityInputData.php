<?php

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\InputData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Cms\Models\Collections\Template;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property string $defaultValue The value of the "default value" attribute.
 * @property array $collections The value of the "collections" attribute.
 * @property boolean $multiple The value of the "multiple" attribute.
 */
class EntityInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param string $defaultValue The value of the "default value" attribute.
     * @param array $collections The value of the "collections" attribute.
     * @param boolean $multiple The value of the "multiple" attribute.
     *
     * @return void
     */
    public function __construct(
        string $defaultValue = '',
        array $collections = [],
        bool $multiple = false,
    )
    {
        $this->set(self::COLLECTIONS, $collections);
        $this->set(self::DEFAULT_VALUE, $defaultValue);
        $this->set(self::MULTIPLE, $multiple);

        parent::__construct(static::TYPE);
    }

    #endregion

    #region CONSTANTS

    /**
     * The name of the "collections" attribute.
     *
     * @var string
     */
    final public const COLLECTIONS = 'collections';

    /**
     * The name of the "multiple" attribute.
     *
     * @var string
     */
    final public const MULTIPLE = 'multiple';

    /**
     * The name of the "type" attribute.
     *
     * @var string
     */
    final public const TYPE = 'entity';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getInputForm(?string $prefix = null): array
    {
        return [
            new FieldData(
                id: 'collections',
                prefix: $prefix,
                input: new SelectInputData(
                    multiple: true,
                    options: Template::options(),
                ),
            ),
            new FieldData(
                id: self::MULTIPLE,
                prefix: $prefix,
                input: new SwitchInputData(),
            ),
        ];
    }

    #endregion
}
