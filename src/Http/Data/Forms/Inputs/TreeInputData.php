<?php

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\InputData;
use Narsil\Base\Support\TranslationsBag;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property array $defaultValue The "default value" attribute of the input.
 */
class TreeInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param array $defaultValue The "default value" attribute of the input.
     *
     * @return void
     */
    public function __construct(
        array $defaultValue = [],
    )
    {
        $this->set('defaultValue', $defaultValue);

        parent::__construct('tree');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public static function registerTranslations(): void
    {
        app(TranslationsBag::class)
            ->add('narsil::ui.add_child')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.edit')
            ->add('narsil::ui.move_down')
            ->add('narsil::ui.move_up');
    }

    #endregion
}
