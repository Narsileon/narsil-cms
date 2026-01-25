<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\NumberField;
use Narsil\Contracts\Fields\TextField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TextField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue('');
        $this->type('text');

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [
            [
                BlockElement::HANDLE => Field::PLACEHOLDER,
                BlockElement::LABEL => trans('narsil::validation.attributes.placeholder'),
                BlockElement::TRANSLATABLE => true,
                BlockElement::RELATION_BASE => [
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.value" : 'value',
                BlockElement::LABEL => trans('narsil::validation.attributes.default_value'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => Contract::class,
                    Field::SETTINGS => app(Contract::class),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.min_length" : 'min_length',
                BlockElement::LABEL => trans('narsil::validation.attributes.min_length'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->max(255)
                        ->min(0)
                        ->step(1)
                        ->defaultValue(0),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.max_length" : 'max_length',
                BlockElement::LABEL => trans('narsil::validation.attributes.max_length'),
                BlockElement::TRANSLATABLE => true,
                BlockElement::RELATION_BASE => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->max(255)
                        ->min(0)
                        ->step(1)
                        ->defaultValue(255),
                ],
            ],
        ];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function autoComplete(string $autoComplete): static
    {
        $this->set('autoComplete', $autoComplete);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function defaultValue(string $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function generate(string $value): static
    {
        $this->set('generate', $value);

        app(TranslationsBag::class)
            ->add('narsil::ui.generate');

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function icon(string $icon): static
    {
        $this->set('icon', $icon);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function maxLength(string $maxLength): static
    {
        $this->set('maxLength', $maxLength);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function minLength(string $minLength): static
    {
        $this->set('minLength', $minLength);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function smartValues(string $smartValues): static
    {
        $this->set('smartValues', $smartValues);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function type(string $type): static
    {
        $this->set('type', $type);

        return $this;
    }

    #endregion

    #endregion
}
