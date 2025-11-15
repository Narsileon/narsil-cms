<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Form;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Support\SelectOption;
use Narsil\Support\TranslationsBag;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm extends Fluent implements Form
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $layout = $this->getLayout();

        $this
            ->defaultLanguage(config('app.locale'))
            ->languageOptions(config('narsil.locales'))
            ->layout($layout)
            ->submitLabel(trans('narsil::ui.save'));

        app(TranslationsBag::class)
            ->add('narsil::accessibility.required')
            ->add('narsil::datetime.by')
            ->add('narsil::datetime.created')
            ->add('narsil::datetime.updated')
            ->add('narsil::dialogs.descriptions.delete')
            ->add('narsil::dialogs.titles.delete')
            ->add('narsil::pagination.pages_empty')
            ->add('narsil::placeholders.choose')
            ->add('narsil::placeholders.search')
            ->add('narsil::ui.add')
            ->add('narsil::ui.add_another')
            ->add('narsil::ui.all')
            ->add('narsil::ui.back')
            ->add('narsil::ui.cancel')
            ->add('narsil::ui.confirm')
            ->add('narsil::ui.continue')
            ->add('narsil::ui.create')
            ->add('narsil::ui.default_language')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.save')
            ->add('narsil::ui.save_as_new')
            ->add('narsil::ui.translations');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function action(string $action): static
    {
        $this->set('action', $action);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function autoSave(string $autoSave): static
    {
        $this->set('autoSave', $autoSave);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function defaultLanguage(string $defaultLanguage): static
    {
        $this->set('defaultLanguage', $defaultLanguage);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function id(mixed $id): static
    {
        $this->set('id', $id);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function languageOptions(array $locales): static
    {
        $languageOptions = [];

        foreach ($locales as $locale)
        {
            $label = Str::ucfirst(Locale::getDisplayName($locale, App::getLocale()));

            $languageOptions[] = new SelectOption()
                ->optionLabel($label)
                ->optionValue($locale);
        }

        $this->set('languageOptions', $languageOptions);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function layout(array $layout): static
    {
        $this->set('layout', $layout);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function method(string $method): static
    {
        $this->set('method', $method);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function routes(array $routes): static
    {
        $this->set('routes', $routes);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function submitIcon(?string $submitIcon): static
    {
        $this->set('submitIcon', $submitIcon);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function submitLabel(string $submitLabel): static
    {
        $this->set('submitLabel', $submitLabel);

        return $this;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Define the layout of the form.
     *
     * @return array
     */
    abstract protected function getLayout(): array;

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
