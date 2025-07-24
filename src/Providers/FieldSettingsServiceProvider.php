<?php

namespace Narsil\Providers;

#region USE

use Narsil\Contracts\Fields\Datetime\DateFieldSettings as DateFieldSettingsContract;
use Narsil\Contracts\Fields\Datetime\TimeFieldSettings as TimeFieldSettingsContract;
use Narsil\Contracts\Fields\Enum\CheckboxFieldSettings as CheckboxFieldSettingsContract;
use Narsil\Contracts\Fields\Enum\SwitchFieldSettings as SwitchFieldSettingsContract;
use Narsil\Contracts\Fields\Number\NumberFieldSettings as NumberFieldSettingsContract;
use Narsil\Contracts\Fields\Number\RangeFieldSettings as RangeFieldSettingsContract;
use Narsil\Contracts\Fields\Select\SelectFieldSettings as SelectFieldSettingsContract;
use Narsil\Contracts\Fields\Text\EmailFieldSettings as EmailFieldSettingsContract;
use Narsil\Contracts\Fields\Text\PasswordFieldSettings as PasswordFieldSettingsContract;
use Narsil\Contracts\Fields\Text\TextFieldSettings as TextFieldSettingsContract;
use Narsil\Fields\Datetime\DateFieldSettings;
use Narsil\Fields\Datetime\TimeFieldSettings;
use Narsil\Fields\Enum\CheckboxFieldSettings;
use Narsil\Fields\Enum\SwitchFieldSettings;
use Narsil\Fields\Number\NumberFieldSettings;
use Narsil\Fields\Number\RangeFieldSettings;
use Narsil\Fields\Select\SelectFieldSettings;
use Narsil\Fields\Text\EmailFieldSettings;
use Narsil\Fields\Text\PasswordFieldSettings;
use Narsil\Fields\Text\TextFieldSettings;
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
