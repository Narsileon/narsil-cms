<?php

namespace Narsil\Services;

#region USE

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\DateField;
use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\NumberField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Fields\RangeField;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\RichTextField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Fields\TimeField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class MigrationService
{
    #region PUBLIC METHODS

    /**
     * @param Template $template
     *
     * @return void
     */
    public static function syncTable(Template $template): void
    {
        $table = $template->{Template::HANDLE};

        $originalFields = TemplateService::getTemplateFields($template);
        $originalHandles = $originalFields->pluck(Field::HANDLE);

        $template = $template->refresh();

        $fields = TemplateService::getTemplateFields($template);
        $handles = $fields->pluck(Field::HANDLE);

        $deletedHandles = $originalHandles->diff($handles);
        $deletedFields = $originalFields->whereIn(Field::HANDLE, $deletedHandles)->values();

        static::addColumns($table, $fields);
        static::dropColumns($table, $deletedFields);

        $template->touch();

        GraphQLService::generateTemplatesSchema();

        Cache::forget("narsil.tables:$table");
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Blueprint $table
     * @param Field $field
     *
     * @return void
     */
    protected static function addColumn(Blueprint $table, Field $field): void
    {
        $handle = $field->{Field::HANDLE};

        $column = match ($field->{Field::TYPE})
        {
            CheckboxField::class => $table->boolean($handle),
            DateField::class => $table->date($handle),
            EmailField::class => $table->string($handle),
            NumberField::class => $table->integer($handle),
            PasswordField::class => $table->string($handle),
            RangeField::class => $table->integer($handle),
            RelationsField::class => $table->json($handle),
            RichTextField::class => $table->text($handle),
            SelectField::class => $table->string($handle),
            SwitchField::class => $table->boolean($handle),
            TextField::class => $table->text($handle),
            TimeField::class => $table->time($handle),
            default => null,
        };

        if ($column === null)
        {
            return;
        }

        $column->nullable(!Arr::get($field->{Field::SETTINGS}, 'required', false));
        $column->default(Arr::get($field->{Field::SETTINGS}, 'value', null));
    }

    /**
     * @param string $table
     * @param Collection $fields
     *
     * @return void
     */
    protected static function addColumns(string $table, Collection $fields): void
    {
        Schema::table($table, function (Blueprint $blueprint) use ($fields, $table)
        {
            foreach ($fields as $field)
            {
                if (!Schema::hasColumn($table, $field->{Field::HANDLE}))
                {
                    static::addColumn($blueprint, $field);
                }
            }
        });
    }

    /**
     * @param string $table
     * @param Collection $fields
     *
     * @return void
     */
    protected static function dropColumns(string $table, Collection $fields): void
    {
        Schema::table($table, function (Blueprint $blueprint) use ($fields, $table)
        {
            foreach ($fields as $field)
            {
                if (Schema::hasColumn($table, $field->{Field::HANDLE}))
                {
                    $blueprint->dropColumn($field->{Field::HANDLE});
                }
            }
        });
    }

    #endregion
}
