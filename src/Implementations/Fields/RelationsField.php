<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\RelationsField as Contract;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Support\TranslationsBag;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RelationsField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil::ui.cancel')
            ->add('narsil::ui.confirm')
            ->add('narsil::ui.edit')
            ->add('narsil::ui.remove')
            ->add('narsil::ui.save')
            ->add('narsil::validation.unique', [
                'attribute' => trans('narsil::validation.attributes.identifier'),
            ]);

        $this->defaultValue([]);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [
            new Field([
                Field::HANDLE => $prefix ? "$prefix.collections" : 'collections',
                Field::NAME => trans('narsil::ui.collections'),
                Field::TYPE => SelectField::class,
                Field::RELATION_OPTIONS => Template::selectOptions(),
                Field::SETTINGS => app(SelectField::class)
                    ->multiple(true),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.multiple" : 'multiple',
                Field::NAME => trans('narsil::validation.attributes.multiple'),
                Field::TYPE => CheckboxField::class,
                Field::SETTINGS => app(CheckboxField::class),
            ]),
        ];
    }

    #region • FLUENT

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
    final public function collections(array $collections): static
    {
        $this->set('collections', $collections);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function columns(int $columns): static
    {
        $this->set('columns', $columns);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function defaultValue(array $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function form(array $form): static
    {
        $this->set('form', $form);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function intermediate(
        Field $relation,
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
     * {@inheritDoc}
     */
    final public function multiple(bool $multiple): static
    {
        $this->set('multiple', $multiple);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function options(array $options): static
    {
        $this->set('options', $options);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function unique(bool $unique): static
    {
        $this->set('unique', $unique);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function widthOptions(array $widthOptions): static
    {
        $this->set('widthOptions', $widthOptions);

        return $this;
    }

    #endregion

    #endregion
}
