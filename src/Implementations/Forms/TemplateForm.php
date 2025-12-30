<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\BlockElementForm;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Contracts\Forms\TemplateTabForm;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Services\ModelService;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Template::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $blockSelectOptions = static::getBlockSelectOptions();
        $fieldSelectOptions = static::getFieldSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            new TemplateTab([
                TemplateTab::HANDLE => 'definition',
                TemplateTab::NAME => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Template::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Template::SINGULAR,
                            Field::NAME => trans('narsil::validation.attributes.singular'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Template::PLURAL,
                            Field::NAME => trans('narsil::validation.attributes.plural'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Template::RELATION_TABS,
                            Field::NAME => trans('narsil::validation.attributes.tabs'),
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(TemplateTabForm::class)->jsonSerialize())
                                ->intermediate(
                                    label: trans('narsil::validation.attributes.tab'),
                                    optionLabel: TemplateTab::NAME,
                                    optionValue: TemplateTab::HANDLE,
                                    relation: new Field([
                                        Field::HANDLE => TemplateTab::RELATION_ELEMENTS,
                                        Field::NAME => trans('narsil::validation.attributes.elements'),
                                        Field::TYPE => RelationsField::class,
                                        Field::SETTINGS => app(RelationsField::class)
                                            ->form(app(BlockElementForm::class)->jsonSerialize())
                                            ->addOption(
                                                identifier: Block::TABLE,
                                                label: ModelService::getModelLabel(Block::class),
                                                optionLabel: TemplateTabElement::NAME,
                                                optionValue: TemplateTabElement::HANDLE,
                                                options: $blockSelectOptions,
                                                routes: RouteService::getNames(Block::TABLE),
                                            )
                                            ->addOption(
                                                identifier: Field::TABLE,
                                                label: ModelService::getModelLabel(Field::class),
                                                optionLabel: TemplateTabElement::NAME,
                                                optionValue: TemplateTabElement::HANDLE,
                                                options: $fieldSelectOptions,
                                                routes: RouteService::getNames(Field::TABLE),
                                            )
                                            ->widthOptions($widthSelectOptions),
                                    ])
                                )
                                ->placeholder(trans('narsil::ui.add_tab')),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    /**
     * Get the block select options.
     *
     * @return array<SelectOption>
     */
    protected static function getBlockSelectOptions(): array
    {
        return Block::query()
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                $option = new SelectOption()
                    ->id($block->{Block::ID})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($block->{Block::ATTRIBUTE_ICON})
                    ->optionLabel($block->getTranslations(Block::NAME))
                    ->optionValue($block->{Block::HANDLE});

                return $option;
            })
            ->toArray();
    }

    /**
     * Get the field select options.
     *
     * @return array<SelectOption>
     */
    protected static function getFieldSelectOptions(): array
    {
        return Field::query()
            ->orderBy(Field::NAME)
            ->get()
            ->map(function (Field $field)
            {
                return new SelectOption()
                    ->id($field->{Field::ID})
                    ->identifier($field->{Field::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($field->{Field::ATTRIBUTE_ICON})
                    ->optionLabel($field->getTranslations(Field::NAME))
                    ->optionValue($field->{Field::HANDLE});
            })
            ->toArray();
    }

    /**
     * Get the width select options.
     *
     * @return array<SelectOption>
     */
    protected static function getWidthSelectOptions(): array
    {
        $widths = [25, 33, 50, 67, 75, 100];

        $options = [];

        foreach ($widths as $width)
        {
            $options[] = new SelectOption()
                ->optionLabel($width . '%')
                ->optionValue($width);
        }

        return $options;
    }

    #endregion
}
