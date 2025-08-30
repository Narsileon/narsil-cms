<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\RelationsInput as Contract;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Support\LabelsBag;
use Narsil\Support\SelectOption;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RelationsInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil::ui.cancel')
            ->add('narsil::ui.edit')
            ->add('narsil::ui.remove')
            ->add('narsil::ui.save')
            ->add('narsil::validation.unique', [
                'attribute' => trans('narsil::validation.attributes.identifier'),
            ]);

        $this->value([]);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        $templateOptions = static::getTemplateOptions();

        return [
            new Field([
                Field::HANDLE => $prefix ? "$prefix.min" : 'min',
                Field::NAME => trans('narsil::validation.attributes.collection'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->options($templateOptions),
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

    #region • FLUENT METHODS

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
        $this->settings['options'][] = [
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
    final public function columns(int $columns): static
    {
        $this->settings['columns'] = $columns;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function form(array $form): static
    {
        $this->settings['form'] = $form;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function multiple(bool $multiple): static
    {
        $this->settings['multiple'] = $multiple;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function options(array $options): static
    {
        $this->settings['options'] = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->settings['placeholder'] = $placeholder;

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
        $this->settings['intermediate'] = [
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
    final public function value(array $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function widthOptions(array $widthOptions): static
    {
        $this->settings['widthOptions'] = $widthOptions;

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    final public function unique(bool $unique): static
    {
        $this->settings['unique'] = $unique;

        return $this;
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    protected static function getTemplateOptions(): array
    {
        return Template::query()
            ->orderBy(Template::NAME)
            ->get()
            ->map(function (Template $template)
            {
                return new SelectOption($template->{Template::NAME}, $template->{Template::ID});
            })
            ->toArray();
    }

    #endregion
}
