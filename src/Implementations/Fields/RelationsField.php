<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Cms\Contracts\Fields\RelationsField as Contract;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Ui\Support\TranslationsBag;

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
        $this->defaultValue([]);

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function bootTranslations(): void
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::ui.edit')
            ->add('narsil-cms::ui.remove')
            ->add('narsil-cms::ui.save')
            ->add('narsil-cms::validation.unique', [
                'attribute' => trans('narsil-cms::validation.attributes.identifier'),
            ])
            ->add('narsil-ui::ui.cancel')
            ->add('narsil-ui::ui.confirm');
    }

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [];
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
        array $relation,
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
