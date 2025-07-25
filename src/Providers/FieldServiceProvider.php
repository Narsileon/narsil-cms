<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Contracts\Fields\Datetime\DateField as DateFieldContract;
use Narsil\Contracts\Fields\Datetime\TimeField as TimeFieldContract;
use Narsil\Contracts\Fields\Select\CheckboxField as CheckboxFieldContract;
use Narsil\Contracts\Fields\Select\SwitchField as SwitchFieldContract;
use Narsil\Contracts\Fields\Number\NumberField as NumberFieldContract;
use Narsil\Contracts\Fields\Number\RangeField as RangeFieldContract;
use Narsil\Contracts\Fields\Select\SelectField as SelectFieldContract;
use Narsil\Contracts\Fields\Text\EmailField as EmailFieldContract;
use Narsil\Contracts\Fields\Text\PasswordField as PasswordFieldContract;
use Narsil\Contracts\Fields\Text\TextField as TextFieldContract;
use Narsil\Fields\Datetime\DateField;
use Narsil\Fields\Datetime\TimeField;
use Narsil\Fields\Select\CheckboxField;
use Narsil\Fields\Select\SwitchField;
use Narsil\Fields\Number\NumberField;
use Narsil\Fields\Number\RangeField;
use Narsil\Fields\Select\SelectField;
use Narsil\Fields\Text\EmailField;
use Narsil\Fields\Text\PasswordField;
use Narsil\Fields\Text\TextField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $fields = $this->fields();

        foreach ($fields as $abstract => $concrete)
        {
            $this->app->bind($abstract, $concrete);
            $this->app->tag($abstract, ['fields']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function fields(): array
    {
        return [
            CheckboxFieldContract::class => CheckboxField::class,
            DateFieldContract::class => DateField::class,
            EmailFieldContract::class => EmailField::class,
            NumberFieldContract::class => NumberField::class,
            SelectFieldContract::class => SelectField::class,
            PasswordFieldContract::class => PasswordField::class,
            RangeFieldContract::class => RangeField::class,
            SwitchFieldContract::class => SwitchField::class,
            TextFieldContract::class => TextField::class,
            TimeFieldContract::class => TimeField::class,
        ];
    }

    #endregion
}
