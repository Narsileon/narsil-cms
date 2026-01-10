<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\RichTextField as Contract;
use Narsil\Contracts\Fields\TextField;
use Narsil\Enums\Forms\RichTextEditorEnum;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Support\TranslationsBag;

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
            ->add('narsil::rich-text-editor.align_center')
            ->add('narsil::rich-text-editor.align_justify')
            ->add('narsil::rich-text-editor.align_left')
            ->add('narsil::rich-text-editor.align_right')
            ->add('narsil::rich-text-editor.bold')
            ->add('narsil::rich-text-editor.bullet_list')
            ->add('narsil::rich-text-editor.heading_1')
            ->add('narsil::rich-text-editor.heading_2')
            ->add('narsil::rich-text-editor.heading_3')
            ->add('narsil::rich-text-editor.heading_4')
            ->add('narsil::rich-text-editor.heading_5')
            ->add('narsil::rich-text-editor.heading_6')
            ->add('narsil::rich-text-editor.headings')
            ->add('narsil::rich-text-editor.italic')
            ->add('narsil::rich-text-editor.ordered_list')
            ->add('narsil::rich-text-editor.redo')
            ->add('narsil::rich-text-editor.strike')
            ->add('narsil::rich-text-editor.subscript')
            ->add('narsil::rich-text-editor.superscript')
            ->add('narsil::rich-text-editor.underline')
            ->add('narsil::rich-text-editor.undo');
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
                BlockElement::HANDLE => $prefix ? "$prefix.modules" : 'modules',
                BlockElement::LABEL => trans("narsil::ui.modules"),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => CheckboxField::class,
                    Field::SETTINGS => app(CheckboxField::class),
                    Field::RELATION_OPTIONS => RichTextEditorEnum::selectOptions(),
                ],
            ],
        ];
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

    #endregion

    #endregion
}
