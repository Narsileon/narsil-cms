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
 * @property array $defaultValue The value of the "default value" attribute.
 */
class TreeInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param array $defaultValue The value of the "default value" attribute.
     *
     * @return void
     */
    public function __construct(
        array $defaultValue = [],
    )
    {
        $this->set(self::DEFAULT_VALUE, $defaultValue);

        parent::__construct(static::TYPE);
    }

    #endregion

    #region CONSTANTS

    /**
     * The name of the "type" attribute.
     *
     * @var string
     */
    final public const TYPE = 'tree';

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
            ->add('narsil::ui.menu')
            ->add('narsil::ui.move_down')
            ->add('narsil::ui.move_up');
    }

    #endregion
}
