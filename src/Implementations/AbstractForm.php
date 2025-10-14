<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Form;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Support\SelectOption;
use Narsil\Support\TranslationsBag;
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
        $this->setLanguageOptions(config('narsil.locales'));

        app(TranslationsBag::class)
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
     * The action of the form.
     *
     * @var string
     */
    protected string $action = '';

    /**
     * The data of the form.
     *
     * @var Model|array
     */
    protected Model|array $data = [];

    /**
     * The description of the form.
     *
     * @var string
     */
    protected string $description = '';

    /**
     * The id of the form.
     *
     * @var integer|string|null
     */
    protected int|string|null $id = null;

    /**
     * The language options of the form.
     *
     * @var array<SelectOption>
     */
    protected array $languageOptions = [];

    /**
     * The method of the form.
     *
     * @var MethodEnum
     */
    protected MethodEnum $method = MethodEnum::POST;

    /**
     * The routes associated to the form.
     *
     * @param array<string,string>
     */
    protected array $routes = [];

    /**
     * The icon of the submit button.
     *
     * @param string|null
     */
    protected ?string $submitIcon = null;

    /**
     * The label of the submit button.
     *
     * @param string
     */
    protected string $submitLabel = '';

    /**
     * The title of the form.
     *
     * @param string
     */
    protected string $title = '';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'action' => $this->getAction(),
            'data' => $this->getData(),
            'description' => $this->getDescription(),
            'id' => $this->getDefaultId($this->id),
            'languageOptions' => $this->getLanguageOptions(),
            'layout' => $this->layout(),
            'method' => $this->getMethod(),
            'routes' => $this->routes,
            'submitIcon' => $this->getSubmitIcon(),
            'submitLabel' => $this->getSubmitLabel(),
            'title' => $this->getTitle(),
        ];
    }

    #region • GETTERS

    /**
     * {@inheritDoc}
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * {@inheritDoc}
     */
    public function getData(): Model|array
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getLanguageOptions(): array
    {
        return $this->languageOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethod(): MethodEnum
    {
        return $this->method;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubmitIcon(): ?string
    {
        return $this->submitIcon;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubmitLabel(): string
    {
        return $this->submitLabel;
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    #endregion

    #region • SETTERS

    /**
     * {@inheritDoc}
     */
    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setData(Model|array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setId(mixed $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setLanguageOptions(array $locales): static
    {
        $languageOptions = [];

        foreach ($locales as $locale)
        {
            $languageOptions[] = new SelectOption(
                label: Str::ucfirst(Locale::getDisplayName($locale, App::getLocale())),
                value: $locale
            )->jsonSerialize();
        }

        $this->languageOptions = $languageOptions;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setMethod(MethodEnum $method): static
    {
        $this->method = $method;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setRoutes(array $routes): static
    {
        $this->routes = $routes;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setSubmitIcon(?string $submitIcon): static
    {
        $this->submitIcon = $submitIcon;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setSubmitLabel(string $submitLabel): static
    {
        $this->submitLabel = $submitLabel;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    #endregion

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
