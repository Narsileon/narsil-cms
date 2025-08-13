<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Support\Str;
use Narsil\Contracts\Form;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Support\LabelsBag;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm implements Form
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->id = $this->getDefaultId();
        $this->submitLabel = trans('narsil::ui.save');

        app(LabelsBag::class)
            ->add('narsil::accessibility.required')
            ->add('narsil::pagination.empty')
            ->add('narsil::placeholders.choose')
            ->add('narsil::placeholders.search')
            ->add('narsil::ui.all')
            ->add('narsil::ui.back')
            ->add('narsil::ui.create')
            ->add('narsil::ui.save');
    }

    #endregion

    #region PROPERTIES

    /**
     * The description of the form.
     */
    public string $description = ''
    {
        get => $this->description;
        set(string $value) => $this->description = $value;
    }

    /**
     * The id of the form.
     */
    public string $id = ''
    {
        get => $this->id;
        set(string $value) => $this->id = $value;
    }

    /**
     * The method of the form.
     */
    public MethodEnum $method = MethodEnum::POST
    {
        get => $this->method;
        set(MethodEnum $value) => $this->method = $value;
    }

    /**
     * The label of the submit button.
     */
    public string $submitLabel = ''
    {
        get => $this->submitLabel;
        set(string $value) => $this->submitLabel = $value;
    }

    /**
     * The title of the form.
     */
    public string $title = ''
    {
        get => $this->title;
        set(string $value) => $this->title = $value;
    }

    /**
     * The url of the form.
     */
    public string $url = ''
    {
        get => $this->url;
        set(string $value) => $this->url = $value;
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'description' => $this->description,
            'form' => static::form(),
            'id'     => $this->id,
            'method' => $this->method,
            'submit' => $this->submitLabel,
            'title'  => $this->title,
            'url'    => $this->url,
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return string
     */
    protected function getDefaultId(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    /**
     * @param ?array $elements
     *
     * @return TemplateSection
     */
    protected static function informationSection(?array $elements = null): TemplateSection
    {
        return new TemplateSection([
            TemplateSection::HANDLE => 'information',
            TemplateSection::NAME => trans('narsil::ui.information'),
            TemplateSection::RELATION_ELEMENTS => [
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'id',
                        Field::NAME => trans('narsil::validation.attributes.id'),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'created_at',
                        Field::NAME => trans('narsil::validation.attributes.created_at'),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'updated_at',
                        Field::NAME => trans('narsil::validation.attributes.updated_at'),
                    ])
                ]),
            ]
        ]);
    }

    /**
     * @param array $elements
     *
     * @return TemplateSection
     */
    protected static function mainSection(array $elements): TemplateSection
    {
        return new TemplateSection([
            TemplateSection::HANDLE => 'main',
            TemplateSection::NAME => trans('narsil::ui.main'),
            TemplateSection::RELATION_ELEMENTS => $elements
        ]);
    }

    /**
     * @param array $elements
     *
     * @return TemplateSection
     */
    protected static function sidebarSection(array $elements): TemplateSection
    {
        return new TemplateSection([
            TemplateSection::HANDLE => 'sidebar',
            TemplateSection::NAME => trans('narsil::ui.sidebar'),
            TemplateSection::RELATION_ELEMENTS => $elements
        ]);
    }

    #endregion
}
