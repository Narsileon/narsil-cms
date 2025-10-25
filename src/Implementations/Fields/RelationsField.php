<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\RelationsField as Contract;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
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

        $this->setDefaultValue([]);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        $templateSelectOptions = static::getTemplateSelectOptions();

        return [
            new Field([
                Field::HANDLE => $prefix ? "$prefix.collections" : 'collections',
                Field::NAME => trans('narsil::ui.collections'),
                Field::TYPE => SelectField::class,
                Field::SETTINGS => app(SelectField::class)
                    ->setOptions($templateSelectOptions)
                    ->setMultiple(true),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.multiple" : 'multiple',
                Field::NAME => trans('narsil::validation.attributes.multiple'),
                Field::TYPE => CheckboxField::class,
                Field::SETTINGS => app(CheckboxField::class),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'relations';
    }

    #region • SETTERS

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
        $this->props['options'][] = [
            'identifier' => $identifier,
            'label' => $label,
            'optionLabel' => $optionLabel,
            'optionValue' => $optionValue,
            'options' => $options,
            'routes' => $routes,
        ];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setColumns(int $columns): static
    {
        $this->props['columns'] = $columns;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(array $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setForm(array $form): static
    {
        $this->props['form'] = $form;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setIntermediate(
        Field $relation,
        string $label,
        string $optionLabel,
        string $optionValue,
    ): static
    {
        $this->props['intermediate'] = [
            'label' => $label,
            'optionLabel' => $optionLabel,
            'optionValue' => $optionValue,
            'relation' => $relation,
        ];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setMultiple(bool $multiple): static
    {
        $this->props['multiple'] = $multiple;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setOptions(array $options): static
    {
        $this->props['options'] = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setPlaceholder(string $placeholder): static
    {
        $this->props['placeholder'] = $placeholder;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setUnique(bool $unique): static
    {
        $this->props['unique'] = $unique;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setWidthOptions(array $widthOptions): static
    {
        $this->props['widthOptions'] = $widthOptions;

        return $this;
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the template select options.
     *
     * @return array<SelectOption>
     */
    protected static function getTemplateSelectOptions(): array
    {
        return Template::query()
            ->orderBy(Template::NAME)
            ->get()
            ->map(function (Template $template)
            {
                return new SelectOption(
                    label: $template->{Template::NAME},
                    value: (string)$template->{Template::ID},
                );
            })
            ->toArray();
    }

    #endregion
}
