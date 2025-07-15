<?php

namespace App\Http\Forms\Resources;

#region USE

use App\Contracts\Forms\Resources\SiteForm as Contract;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Models\Site;
use App\Support\Forms\Input;
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
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        $languageOptions = static::getLanguageOptions();

        return [
            (new Input(Site::NAME, TypeEnum::TEXT, ''))
                ->setRequired(true)
                ->get(),
            (new Input(Site::PRIMARY, TypeEnum::CHECKBOX, false))
                ->setRequired(true)
                ->get(),
            (new Input(Site::HANDLE, TypeEnum::TEXT, ''))
                ->setRequired(true)
                ->get(),
            (new Input(Site::LANGUAGE, TypeEnum::COMBOBOX, ''))
                ->setOptions($languageOptions)
                ->setPlaceholder(trans('ui.search'))
                ->setRequired(true)
                ->get(),
            (new Input(Site::GROUP_ID, TypeEnum::COMBOBOX, ''))
                ->setPlaceholder(trans('ui.search'))
                ->get(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

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
