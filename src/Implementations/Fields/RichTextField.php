<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Base\Enums\RichTextEditorEnum;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Fields\CheckboxField;
use Narsil\Cms\Contracts\Fields\RichTextField as Contract;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

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
            ->add('narsil-ui::rich-text-editor.align_center')
            ->add('narsil-ui::rich-text-editor.align_justify')
            ->add('narsil-ui::rich-text-editor.align_left')
            ->add('narsil-ui::rich-text-editor.align_right')
            ->add('narsil-ui::rich-text-editor.bold')
            ->add('narsil-ui::rich-text-editor.bullet_list')
            ->add('narsil-ui::rich-text-editor.heading_1')
            ->add('narsil-ui::rich-text-editor.heading_2')
            ->add('narsil-ui::rich-text-editor.heading_3')
            ->add('narsil-ui::rich-text-editor.heading_4')
            ->add('narsil-ui::rich-text-editor.heading_5')
            ->add('narsil-ui::rich-text-editor.heading_6')
            ->add('narsil-ui::rich-text-editor.headings')
            ->add('narsil-ui::rich-text-editor.italic')
            ->add('narsil-ui::rich-text-editor.ordered_list')
            ->add('narsil-ui::rich-text-editor.redo')
            ->add('narsil-ui::rich-text-editor.strike')
            ->add('narsil-ui::rich-text-editor.subscript')
            ->add('narsil-ui::rich-text-editor.superscript')
            ->add('narsil-ui::rich-text-editor.underline')
            ->add('narsil-ui::rich-text-editor.undo');
    }

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [
            [
                BlockElement::HANDLE => Field::PLACEHOLDER,
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.placeholder'),
                BlockElement::TRANSLATABLE => true,
                BlockElement::RELATION_BASE => [
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.modules" : 'modules',
                BlockElement::LABEL => trans('narsil-cms::ui.modules'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => CheckboxField::class,
                    Field::SETTINGS => app(CheckboxField::class),
                    Field::RELATION_OPTIONS => RichTextEditorEnum::options(),
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
