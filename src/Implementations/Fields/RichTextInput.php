<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\RichTextInput as Contract;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RichTextInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->type('text');
        $this->value('');

        app(LabelsBag::class)
            ->add('narsil-cms::accessibility.align_center')
            ->add('narsil-cms::accessibility.align_justify')
            ->add('narsil-cms::accessibility.align_left')
            ->add('narsil-cms::accessibility.align_right')
            ->add('narsil-cms::accessibility.redo')
            ->add('narsil-cms::accessibility.required')
            ->add('narsil-cms::accessibility.toggle_bold')
            ->add('narsil-cms::accessibility.toggle_bullet_list')
            ->add('narsil-cms::accessibility.toggle_heading_1')
            ->add('narsil-cms::accessibility.toggle_heading_2')
            ->add('narsil-cms::accessibility.toggle_heading_3')
            ->add('narsil-cms::accessibility.toggle_heading_4')
            ->add('narsil-cms::accessibility.toggle_heading_5')
            ->add('narsil-cms::accessibility.toggle_heading_6')
            ->add('narsil-cms::accessibility.toggle_heading_menu')
            ->add('narsil-cms::accessibility.toggle_italic')
            ->add('narsil-cms::accessibility.toggle_ordered_list')
            ->add('narsil-cms::accessibility.toggle_strike')
            ->add('narsil-cms::accessibility.toggle_subscript')
            ->add('narsil-cms::accessibility.toggle_superscript')
            ->add('narsil-cms::accessibility.toggle_underline')
            ->add('narsil-cms::accessibility.undo');
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
                Field::HANDLE => $prefix ? "$prefix.placeholder" : 'placeholder',
                Field::NAME => trans('narsil-cms::validation.attributes.placeholder'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'rich-text';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.rich_text');
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
    final public function required(bool $required): static
    {
        $this->settings['required'] = $required;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(string $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    #endregion
}
