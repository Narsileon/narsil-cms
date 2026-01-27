<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Form;
use Narsil\Models\Collections\TemplateTab;
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
     * @param Model|null $model
     *
     * @return void
     */
    public function __construct(?Model $model = null)
    {
        $defaultLanguage = Config::get('app.locale', 'en');
        $languageOptions = Config::get('narsil.locales', []);

        $id = $this->getDefaultId();
        $tabs = $this->getTabs();

        $this
            ->defaultLanguage($defaultLanguage)
            ->id($id)
            ->languageOptions($languageOptions)
            ->submitLabel(trans('narsil::ui.save'))
            ->tabs($tabs);

        foreach (Config::get('narsil.fields', []) as $field)
        {
            app($field)::bootTranslations();
        }

        app(TranslationsBag::class)
            ->add('narsil::accessibility.required')
            ->add('narsil::datetime.by')
            ->add('narsil::datetime.created')
            ->add('narsil::datetime.updated')
            ->add('narsil::dialogs.descriptions.delete')
            ->add('narsil::dialogs.titles.delete')
            ->add('narsil::field-placeholders.choose')
            ->add('narsil::field-placeholders.search')
            ->add('narsil::pagination.pages_empty')
            ->add('narsil::ui.add_another')
            ->add('narsil::ui.add')
            ->add('narsil::ui.all')
            ->add('narsil::ui.back')
            ->add('narsil::ui.cancel')
            ->add('narsil::ui.confirm')
            ->add('narsil::ui.continue')
            ->add('narsil::ui.create')
            ->add('narsil::ui.default_language')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.publish')
            ->add('narsil::ui.save_as_new')
            ->add('narsil::ui.save')
            ->add('narsil::ui.translations')
            ->add('narsil::ui.unpublish');
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

    /**
     * {@inheritDoc}
     */
    public function tabs(array $tabs): static
    {
        $this->set('tabs', $tabs);

        return $this;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Define the layout of the form.
     *
     * @return array
     */
    abstract protected function getTabs(): array;

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
     * @return TemplateTab
     */
    protected static function sidebarTab(array $elements): TemplateTab
    {
        return new TemplateTab([
            TemplateTab::HANDLE => 'sidebar',
            TemplateTab::LABEL => trans('narsil::ui.sidebar'),
            TemplateTab::RELATION_ELEMENTS => $elements
        ]);
    }

    #endregion
}
