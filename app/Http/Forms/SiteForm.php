<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\TypeEnum;
use App\Models\Site;
use App\Services\TranslationService;
use App\Structures\Input;
use Locale;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteForm extends AbstractForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected static function inputs(): array
    {
        $locales = static::getLanguageOptions();

        return [
            (new Input(Site::NAME))
                ->required(true)
                ->get(),
            (new Input(Site::PRIMARY))
                ->type(TypeEnum::CHECKBOX)
                ->required(true)
                ->get(),
            (new Input(Site::HANDLE))
                ->required(true)
                ->get(),
            (new Input(Site::LANGUAGE))
                ->type(TypeEnum::COMBOBOX)
                ->options($locales)
                ->required(true)
                ->get(),
            (new Input(Site::GROUP_ID))
                ->get(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected static function getLanguageOptions(): array
    {
        $locales = ResourceBundle::getLocales('');

        $currentLocale = TranslationService::getLocale();

        $options = [];

        foreach ($locales as $locale)
        {
            $options[] = [
                'value' => $locale,
                'label' => Locale::getDisplayName($locale, $currentLocale),
            ];
        }

        usort($options, function ($a, $b)
        {
            return strcmp($a['label'], $b['label']);
        });


        return $options;
    }

    #endregion
}
