<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Database\Eloquent\Model;
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
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class AbstractForm implements Form
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil::accessibility.required')
            ->add('narsil::pagination.pages_empty')
            ->add('narsil::placeholders.choose')
            ->add('narsil::placeholders.search')
            ->add('narsil::ui.add')
            ->add('narsil::ui.add_another')
            ->add('narsil::ui.all')
            ->add('narsil::ui.back')
            ->add('narsil::ui.continue')
            ->add('narsil::ui.create')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.save')
            ->add('narsil::ui.save_as_new');
    }

    #endregion

    #region PROPERTIES

    /**
     * The routes associated to the form.
     *
     * @param array<string,string>
     */
    protected array $routes = [];

    /**
     * {@inheritDoc}
     */
    public string $action = ''
    {
        get => $this->action;
        set(string $value) => $this->action = $value;
    }

    /**
     * {@inheritDoc}
     */
    public Model|array $data = []
    {
        get => $this->data;
        set(Model|array $value) => $this->data = $value;
    }

    /**
     * {@inheritDoc}
     */
    public string $description = ''
    {
        get => $this->description;
        set(string $value) => $this->description = $value;
    }

    /**
     * {@inheritDoc}
     */
    public mixed $id = null
    {
        get => $this->id;
        set(mixed $value) => $this->id = $value;
    }

    /**
     * {@inheritDoc}
     */
    public MethodEnum $method = MethodEnum::POST
    {
        get => $this->method;
        set(MethodEnum $value) => $this->method = $value;
    }

    /**
     * {@inheritDoc}
     */
    public ?string $submitIcon = null
    {
        get => $this->submitIcon;
        set(?string $value) => $this->submitIcon = $value;
    }

    /**
     * {@inheritDoc}
     */
    public string $submitLabel = ''
    {
        get => $this->submitLabel;
        set(string $value) => $this->submitLabel = $value;
    }

    /**
     * {@inheritDoc}
     */
    public string $title = ''
    {
        get => $this->title;
        set(string $value) => $this->title = $value;
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'action' => $this->action,
            'data' => $this->data,
            'description' => $this->description,
            'id' => $this->getDefaultId($this->id),
            'layout' => $this->layout(),
            'method' => $this->method,
            'routes' => $this->routes,
            'submitIcon' => $this->submitIcon,
            'submitLabel' => $this->submitLabel,
            'title' => $this->title,
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param mixed $id
     *
     * @return string
     */
    protected function getDefaultId(mixed $id = null): string
    {
        $name = new ReflectionClass(static::class)->getShortName();

        $slug = Str::slug(Str::snake($name));

        return $id ? "$slug-$id" : $slug;
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
