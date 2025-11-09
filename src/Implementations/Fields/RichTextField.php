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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RichTextField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue('');

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
                Field::RELATION_OPTIONS => RichTextEditorEnum::options(),
                Field::SETTINGS => app(CheckboxField::class),
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

    #region • FLUENT

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
    final public function modules(array $modules): static
    {
        $this->set('modules', $modules);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->set('placeholder', $placeholder);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->set('required', $required);

        return $this;
    }

    #endregion

    #endregion
}
