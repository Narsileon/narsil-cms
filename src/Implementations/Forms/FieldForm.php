<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FieldForm as Contract;
use Narsil\Enums\Forms\RuleEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class FieldForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil::models.field');
        $this->routes = RouteService::getNames(Field::TABLE);
        $this->submitLabel = trans('narsil::ui.save');
        $this->title = trans('narsil::models.field');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        $settings = [];

        $abstract = request()->get(Field::TYPE);

        if ($abstract)
        {
            $concrete = config("narsil.fields.$abstract");

            $elements = $concrete::getForm(Field::SETTINGS);

            foreach ($elements as $element)
            {
                $blockElement = new BlockElement([
                    BlockElement::RELATION_ELEMENT => $element,
                ]);

                $settings[] = $blockElement;
            }
        }

        $rulesOptions = static::getRulesOptions();
        $typeOptions = static::getTypeOptions();

        $content = [
            static::mainSection(array_merge([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::NAME,
                        Field::NAME => trans('narsil::ui.default_name'),
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::HANDLE,
                        Field::NAME => trans('narsil::ui.default_handle'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::TYPE,
                        Field::NAME => trans('narsil::validation.attributes.type'),
                        Field::TYPE => SelectField::class,
                        Field::SETTINGS => app(SelectField::class)
                            ->setOptions($typeOptions)
                            ->setPlaceholder(trans('narsil::placeholders.search'))
                            ->setReload('layout')
                            ->setRequired(true),

                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::NAME,
                        Field::NAME => trans('narsil::validation.attributes.translatable'),
                        Field::TYPE => CheckboxField::class,
                        Field::SETTINGS => app(CheckboxField::class),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Block([
                        Block::COLLAPSIBLE => true,
                        Block::NAME => trans('narsil::ui.settings'),
                        Block::RELATION_ELEMENTS =>  $settings,
                    ]),
                ]),
            ])),
            new TemplateSection([
                TemplateSection::HANDLE => 'validation',
                TemplateSection::NAME => trans('narsil::ui.validation'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => 'rules',
                            Field::NAME => trans("narsil::ui.rules"),
                            Field::TYPE => CheckboxField::class,
                            Field::SETTINGS => app(CheckboxField::class)
                                ->setOptions($rulesOptions),
                        ]),
                    ]),
                ],
            ]),
            static::informationSection(),
        ];

        return $content;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the rules options.
     *
     * @return array<SelectOption>
     */
    protected static function getRulesOptions(): array
    {
        $options = [];

        foreach (RuleEnum::cases() as $case)
        {
            $options[] = new SelectOption(
                label: trans("narsil::rules.$case->value"),
                value: $case->value
            );
        }

        return $options;
    }

    /**
     * Get the type options.
     *
     * @return array<string>
     */
    protected static function getTypeOptions(): array
    {
        $options = [];

        foreach (config('narsil.fields', []) as $abstract => $concrete)
        {
            $options[] = new SelectOption(
                label: trans('narsil::fields.' . $abstract),
                value: $abstract
            )
                ->setIcon($concrete::getIcon());
        }

        return $options;
    }

    #endregion
}
