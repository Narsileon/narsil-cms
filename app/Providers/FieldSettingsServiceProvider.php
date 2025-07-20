<?php

namespace App\Providers;

#region USE

use App\Contracts\Fields\Datetime\DateFieldSettings as DateFieldSettingsContract;
use App\Contracts\Fields\Datetime\TimeFieldSettings as TimeFieldSettingsContract;
use App\Contracts\Fields\Enum\CheckboxFieldSettings as CheckboxFieldSettingsContract;
use App\Contracts\Fields\Enum\SwitchFieldSettings as SwitchFieldSettingsContract;
use App\Contracts\Fields\Number\NumberFieldSettings as NumberFieldSettingsContract;
use App\Contracts\Fields\Number\RangeFieldSettings as RangeFieldSettingsContract;
use App\Contracts\Fields\Select\SelectFieldSettings as SelectFieldSettingsContract;
use App\Contracts\Fields\Text\EmailFieldSettings as EmailFieldSettingsContract;
use App\Contracts\Fields\Text\PasswordFieldSettings as PasswordFieldSettingsContract;
use App\Contracts\Fields\Text\TextFieldSettings as TextFieldSettingsContract;
use App\Fields\Datetime\DateFieldSettings;
use App\Fields\Datetime\TimeFieldSettings;
use App\Fields\Enum\CheckboxFieldSettings;
use App\Fields\Enum\SwitchFieldSettings;
use App\Fields\Number\NumberFieldSettings;
use App\Fields\Number\RangeFieldSettings;
use App\Fields\Select\SelectFieldSettings;
use App\Fields\Text\EmailFieldSettings;
use App\Fields\Text\PasswordFieldSettings;
use App\Fields\Text\TextFieldSettings;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSettingsServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->app->bind(CheckboxFieldSettingsContract::class, CheckboxFieldSettings::class);
        $this->app->bind(DateFieldSettingsContract::class, DateFieldSettings::class);
        $this->app->bind(EmailFieldSettingsContract::class, EmailFieldSettings::class);
        $this->app->bind(NumberFieldSettingsContract::class, NumberFieldSettings::class);
        $this->app->bind(SelectFieldSettingsContract::class, SelectFieldSettings::class);
        $this->app->bind(PasswordFieldSettingsContract::class, PasswordFieldSettings::class);
        $this->app->bind(RangeFieldSettingsContract::class, RangeFieldSettings::class);
        $this->app->bind(SwitchFieldSettingsContract::class, SwitchFieldSettings::class);
        $this->app->bind(TextFieldSettingsContract::class, TextFieldSettings::class);
        $this->app->bind(TimeFieldSettingsContract::class, TimeFieldSettings::class);
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion
}
