<?php

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\InputData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property string $defaultValue The "default value" attribute of the input.
 * @property string $placeholder The "placeholder" attribute of the input.
 * @property bool $multiple The "multiple" attribute of the input.
 */
class LinkInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param string $defaultValue The "default value" attribute of the input.
     * @param string $placeholder The "placeholder" attribute of the input.
     * @param bool $multiple The "multiple" attribute of the input.
     *
     * @return void
     */
    public function __construct(
        string $defaultValue = '',
        string $placeholder = '',
        bool $multiple = false
    )
    {
        $this->set('defaultValue', $defaultValue);
        $this->set('placeholder', $placeholder);
        $this->set('multiple', $multiple);

        parent::__construct('link');
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
