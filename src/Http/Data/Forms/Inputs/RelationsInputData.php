<?php

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\InputData;
use Narsil\Base\Support\TranslationsBag;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property array $defaultValue The "default value" attribute of the input.
 */
class RelationsInputData extends InputData
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

        parent::__construct('relations');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    final public function addOption(
        string $identifier,
        string $label,
        string $optionLabel,
        string $optionValue,
        array $options = [],
        array $routes = [],
    ): static
    {
        $option = [
            'identifier' => $identifier,
            'label' => $label,
            'optionLabel' => $optionLabel,
            'optionValue' => $optionValue,
            'options' => $options,
            'routes' => $routes,
        ];

        $this->set('options', array_merge($this->get('options', []), [$option]));

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function intermediate(
        FieldData $relation,
        string $label,
        string $optionLabel,
        string $optionValue,
    ): static
    {
        $this->set('intermediate', [
            'label' => $label,
            'optionLabel' => $optionLabel,
            'optionValue' => $optionValue,
            'relation' => $relation,
        ]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function registerTranslations(): void
    {
        app(TranslationsBag::class)
            ->add('narsil::ui.add')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.move_down')
            ->add('narsil::ui.move_up');
    }

    #endregion
}
