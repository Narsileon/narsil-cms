<?php

namespace Narsil\Forms\Resources;

#region USE

use Illuminate\Support\Facades\App;
use Locale;
use Narsil\Contracts\Fields\Select\SelectField;
use Narsil\Contracts\Fields\Select\SwitchField;
use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Resources\SiteForm as Contract;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function content(): array
    {
        $groupOptions = $this->getGroupOptions();
        $languageOptions = $this->getLanguageOptions();

        return [
            new Field([
                Field::HANDLE => Site::NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.name'),
                Field::SETTINGS => app(TextField::class)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::HANDLE,
                Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                Field::SETTINGS => app(TextField::class)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::LANGUAGE,
                Field::NAME => trans('narsil-cms::validation.attributes.language'),
                Field::SETTINGS => app(SelectField::class)
                    ->options($languageOptions)
                    ->placeholder(trans('placeholders.search'))
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::GROUP_ID,
                Field::NAME => trans('narsil-cms::validation.attributes.group'),
                Field::SETTINGS => app(SelectField::class)
                    ->options($groupOptions)
                    ->placeholder(trans('narsil::placeholders.search'))
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function meta(): array
    {
        return [
            new Field([
                Field::HANDLE => Site::ID,
                Field::NAME => trans('narsil-cms::validation.attributes.id'),
            ]),
            new Field([
                Field::HANDLE => Site::CREATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
            ]),
            new Field([
                Field::HANDLE => Site::UPDATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function sidebar(): array
    {
        return [
            new Field([
                Field::HANDLE => Site::ENABLED,
                Field::NAME => trans('narsil-cms::validation.attributes.enabled'),
                Field::SETTINGS => app(SwitchField::class)
                    ->checked(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::PRIMARY,
                Field::NAME => trans('narsil-cms::validation.attributes.primary'),
                Field::SETTINGS => app(SwitchField::class)
                    ->toArray(),
            ]),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected function getGroupOptions(): array
    {
        $groups = SiteGroup::query()
            ->orderBy(SiteGroup::NAME)
            ->get();

        $options = [];

        foreach ($groups as $group)
        {
            $options[] = [
                'value' => $group->{SiteGroup::ID},
                'label' => $group->{SiteGroup::NAME},
            ];
        }

        return $options;
    }

    /**
     * @return array<string>
     */
    protected function getLanguageOptions(): array
    {
        $locales = ResourceBundle::getLocales('');

        $options = [];

        foreach ($locales as $locale)
        {
            $options[] = [
                'value' => $locale,
                'label' => Locale::getDisplayName($locale, App::getLocale()),
            ];
        }

        usort($options, function ($a, $b)
        {
            return strcmp($a['label'], $b['label']);
        });


        return array_values($options);
    }

    #endregion
}
