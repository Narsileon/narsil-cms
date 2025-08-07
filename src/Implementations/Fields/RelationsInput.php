<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\RelationsInput as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
            ->add('narsil-cms::ui.cancel')
            ->add('narsil-cms::ui.edit')
            ->add('narsil-cms::ui.remove')
            ->add('narsil-cms::ui.save');

        $this->value([]);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'relations';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.relations');
    }

    #endregion

    #region FLUENT METHODS

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
}
