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
        $this->locales(config('narsil.locales'));

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
     * The routes associated to the form.
     *
     * @param array<string,string>
     */
    protected array $routes = [];

    /**
     * {@inheritDoc}
     */
    public protected(set) string $action = '';

    /**
     * {@inheritDoc}
     */
    public protected(set) Model|array $data = [];

    /**
     * {@inheritDoc}
     */
    public protected(set) string $description = '';

    /**
     * {@inheritDoc}
     */
    public protected(set) mixed $id = null;

    /**
     * {@inheritDoc}
     */
    public protected(set) array $locales = [];

    /**
     * {@inheritDoc}
     */
    public protected(set) MethodEnum $method = MethodEnum::POST;

    /**
     * {@inheritDoc}
     */
    public protected(set) ?string $submitIcon = null;

    /**
     * {@inheritDoc}
     */
    public protected(set) string $submitLabel = '';

    /**
     * {@inheritDoc}
     */
    public protected(set) string $title = '';

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
            'locales' => $this->locales,
            'method' => $this->method,
            'routes' => $this->routes,
            'submitIcon' => $this->submitIcon,
            'submitLabel' => $this->submitLabel,
            'title' => $this->title,
        ];
    }

    #region • SETTERS

    /**
     * {@inheritDoc}
     */
    public function action(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function data(Model|array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function id(mixed $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function locales(array $locales): static
    {
        $options = [];

        foreach ($locales as $locale)
        {
            $options[] = new SelectOption(
                label: Str::ucfirst(Locale::getDisplayName($locale, App::getLocale())),
                value: $locale
            )->jsonSerialize();
        }

        $this->locales = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function method(MethodEnum $method): static
    {
        $this->method = $method;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function submitIcon(?string $submitIcon): static
    {
        $this->submitIcon = $submitIcon;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function submitLabel(string $submitLabel): static
    {
        $this->submitLabel = $submitLabel;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function title(string $title): static
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
