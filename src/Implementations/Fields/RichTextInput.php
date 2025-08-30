<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\RichTextInput as Contract;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Enums\Forms\RichTextEditorEnum;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Support\LabelsBag;
use Narsil\Support\SelectOption;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
            ->add('narsil::accessibility.align_center')
            ->add('narsil::accessibility.align_justify')
            ->add('narsil::accessibility.align_left')
            ->add('narsil::accessibility.align_right')
            ->add('narsil::accessibility.redo')
            ->add('narsil::accessibility.toggle_bold')
            ->add('narsil::accessibility.toggle_bullet_list')
            ->add('narsil::accessibility.toggle_heading_1')
            ->add('narsil::accessibility.toggle_heading_2')
            ->add('narsil::accessibility.toggle_heading_3')
            ->add('narsil::accessibility.toggle_heading_4')
            ->add('narsil::accessibility.toggle_heading_5')
            ->add('narsil::accessibility.toggle_heading_6')
            ->add('narsil::accessibility.toggle_heading_menu')
            ->add('narsil::accessibility.toggle_italic')
            ->add('narsil::accessibility.toggle_ordered_list')
            ->add('narsil::accessibility.toggle_strike')
            ->add('narsil::accessibility.toggle_subscript')
            ->add('narsil::accessibility.toggle_superscript')
            ->add('narsil::accessibility.toggle_underline')
            ->add('narsil::accessibility.undo');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        $moduleOptions = static::getModulesOptions();

        return [
            new Field([
                Field::HANDLE => $prefix ? "$prefix.placeholder" : 'placeholder',
                Field::NAME => trans('narsil::validation.attributes.placeholder'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.modules" : 'modules',
                Field::NAME => trans("narsil::ui.modules"),
                Field::TYPE => CheckboxInput::class,
                Field::SETTINGS => app(CheckboxInput::class)
                    ->options($moduleOptions),
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

    #region • FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function modules(array $modules): static
    {
        $this->settings['modules'] = $modules;

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

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the modules options.
     *
     * @return array<SelectOption>
     */
    protected static function getModulesOptions(): array
    {
        $options = [];

        foreach (RichTextEditorEnum::cases() as $case)
        {
            $options[] = new SelectOption(
                label: trans("narsil::rich-text-editor.$case->value"),
                value: $case->value
            );
        }

        return $options;
    }

    #endregion
}
