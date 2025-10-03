<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\RichTextField as Contract;
use Narsil\Contracts\Fields\TextField;
use Narsil\Enums\Forms\RichTextEditorEnum;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Support\TranslationsBag;
use Narsil\Support\SelectOption;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RichTextField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setDefaultValue('');

        app(TranslationsBag::class)
            ->add('narsil::rich-text-editor.toggles.align_center')
            ->add('narsil::rich-text-editor.toggles.align_justify')
            ->add('narsil::rich-text-editor.toggles.align_left')
            ->add('narsil::rich-text-editor.toggles.align_right')
            ->add('narsil::rich-text-editor.toggles.bold')
            ->add('narsil::rich-text-editor.toggles.bullet_list')
            ->add('narsil::rich-text-editor.toggles.heading_1')
            ->add('narsil::rich-text-editor.toggles.heading_2')
            ->add('narsil::rich-text-editor.toggles.heading_3')
            ->add('narsil::rich-text-editor.toggles.heading_4')
            ->add('narsil::rich-text-editor.toggles.heading_5')
            ->add('narsil::rich-text-editor.toggles.heading_6')
            ->add('narsil::rich-text-editor.toggles.heading_menu')
            ->add('narsil::rich-text-editor.toggles.italic')
            ->add('narsil::rich-text-editor.toggles.ordered_list')
            ->add('narsil::rich-text-editor.toggles.strike')
            ->add('narsil::rich-text-editor.toggles.subscript')
            ->add('narsil::rich-text-editor.toggles.superscript')
            ->add('narsil::rich-text-editor.toggles.underline')
            ->add('narsil::ui.redo')
            ->add('narsil::ui.undo');
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
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.modules" : 'modules',
                Field::NAME => trans("narsil::ui.modules"),
                Field::TYPE => CheckboxField::class,
                Field::SETTINGS => app(CheckboxField::class)
                    ->setOptions($moduleOptions),
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
    final public function setDefaultValue(string $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setModules(array $modules): static
    {
        $this->props['modules'] = $modules;

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
    final public function setRequired(bool $required): static
    {
        $this->props['required'] = $required;

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
                label: trans("narsil::rich-text-editor.modules.$case->value"),
                value: $case->value
            );
        }

        return $options;
    }

    #endregion
}
