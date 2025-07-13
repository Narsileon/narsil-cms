<?php

namespace App\Http\Forms\Resources;

#region USE

use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\Resources\ISiteForm;
use App\Models\Site;
use App\Support\Input;
use Illuminate\Support\Facades\App;
use Locale;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteForm extends AbstractForm implements ISiteForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getInputs(): array
    {
        $languageOptions = static::getLanguageOptions();

        return [
            (new Input(Site::NAME, ''))
                ->required(true)
                ->get(),
            (new Input(Site::PRIMARY, false))
                ->type(TypeEnum::CHECKBOX)
                ->required(true)
                ->get(),
            (new Input(Site::HANDLE, ''))
                ->required(true)
                ->get(),
            (new Input(Site::LANGUAGE, ''))
                ->type(TypeEnum::COMBOBOX)
                ->options($languageOptions)
                ->required(true)
                ->get(),
            (new Input(Site::GROUP_ID, ''))
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
