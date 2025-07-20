<?php

namespace App\Forms\Resources;

#region USE

use App\Contracts\Fields\Enum\SwitchFieldSettings;
use App\Contracts\Fields\Select\SelectFieldSettings;
use App\Contracts\Fields\Text\TextFieldSettings;
use App\Contracts\Forms\Resources\SiteForm as Contract;
use App\Forms\AbstractForm;
use App\Models\Fields\Field;
use App\Models\Sites\Site;
use App\Models\Sites\SiteGroup;
use Illuminate\Support\Facades\App;
use Locale;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getContent(): array
    {
        $groupOptions = $this->getGroupOptions();
        $languageOptions = $this->getLanguageOptions();

        return [
            new Field([
                Field::HANDLE => Site::NAME,
                Field::NAME => trans('validation.attributes.name'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::HANDLE,
                Field::NAME => trans('validation.attributes.handle'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::LANGUAGE,
                Field::NAME => trans('validation.attributes.language'),
                Field::SETTINGS => app(SelectFieldSettings::class)
                    ->options($languageOptions)
                    ->placeholder(trans('placeholders.search'))
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::GROUP_ID,
                Field::NAME => trans('validation.attributes.group'),
                Field::SETTINGS => app(SelectFieldSettings::class)
                    ->options($groupOptions)
                    ->placeholder(trans('placeholders.search'))
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getSidebar(): array
    {
        return [
            new Field([
                Field::HANDLE => Site::ENABLED,
                Field::NAME => trans('validation.attributes.enabled'),
                Field::SETTINGS => app(SwitchFieldSettings::class)
                    ->checked(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Site::PRIMARY,
                Field::NAME => trans('validation.attributes.primary'),
                Field::SETTINGS => app(SwitchFieldSettings::class)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getMeta(): array
    {
        return [];
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
