<?php

namespace Narsil\Cms\Implementations;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Locale;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Form;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Support\SelectOption;
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
        $this->set('model', $model);

        $defaultLanguage = Config::get('app.locale', 'en');
        $languageOptions = Config::get('narsil.locales', []);

        $id = $this->getDefaultId();
        $tabs = $this->getTabs();

        $this
            ->defaultLanguage($defaultLanguage)
            ->id($id)
            ->languageOptions($languageOptions)
            ->submitLabel(trans('narsil-cms::ui.save'))
            ->tabs($tabs);

        foreach (Config::get('narsil.fields', []) as $field)
        {
            app($field)::bootTranslations();
        }

        app(TranslationsBag::class)
            ->add('narsil-cms::datetime.by')
            ->add('narsil-cms::datetime.created')
            ->add('narsil-cms::datetime.updated')
            ->add('narsil-cms::pagination.pages_empty')
            ->add('narsil-cms::ui.add_another')
            ->add('narsil-cms::ui.add')
            ->add('narsil-cms::ui.all')
            ->add('narsil-cms::ui.back')
            ->add('narsil-cms::ui.continue')
            ->add('narsil-cms::ui.default_language')
            ->add('narsil-cms::ui.publish')
            ->add('narsil-cms::ui.save_as_new')
            ->add('narsil-cms::ui.save')
            ->add('narsil-cms::ui.translations')
            ->add('narsil-cms::ui.unpublish')
            ->add('narsil-ui::dialogs.descriptions.delete')
            ->add('narsil-ui::dialogs.titles.delete')
            ->add('narsil-ui::placeholders.choose')
            ->add('narsil-ui::placeholders.search')
            ->add('narsil-ui::tooltips.required')
            ->add('narsil-ui::ui.cancel')
            ->add('narsil-ui::ui.confirm')
            ->add('narsil-ui::ui.create')
            ->add('narsil-ui::ui.delete');
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
            TemplateTab::LABEL => trans('narsil-cms::ui.sidebar'),
            TemplateTab::RELATION_ELEMENTS => $elements
        ]);
    }

    #endregion
}
