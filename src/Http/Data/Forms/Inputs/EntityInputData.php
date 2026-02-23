<?php

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\InputData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Cms\Models\Collections\Template;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property array $collection The "collection" attribute of the input.
 * @property string $defaultValue The "default value" attribute of the input.
 * @property boolean $multiple The "multiple" attribute of the input.
 * @property string $placeholder The "placeholder" attribute of the input.
 */
class EntityInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param array $collections The "collection" attribute of the input.
     * @param string $defaultValue The "default value" attribute of the input.
     * @param boolean $multiple The "multiple" attribute of the input.
     * @param string $placeholder The "placeholder" attribute of the input.
     *
     * @return void
     */
    public function __construct(
        array $collections,
        string $defaultValue = '',
        bool $multiple = false,
        string $placeholder = '',
    )
    {
        $this->set('collections', $collections);
        $this->set('defaultValue', $defaultValue);
        $this->set('multiple', $multiple);
        $this->set('placeholder', $placeholder);

        parent::__construct('tree');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function form(?string $prefix = null): array
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
                id: 'placeholder',
                prefix: $prefix,
                input: new TextInputData(),
            ),
            new FieldData(
                id: 'multiple',
                prefix: $prefix,
                input: new SwitchInputData(),
            ),
        ];
    }

    #endregion
}
