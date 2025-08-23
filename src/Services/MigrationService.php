<?php

namespace Narsil\Services;

#region USE

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\DateInput;
use Narsil\Contracts\Fields\RichTextInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Fields\TimeInput;
use Narsil\Database\Migrations\CollectionMigration;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\Field;
use Narsil\Services\GraphQLService;
use Narsil\Services\TemplateService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        new CollectionMigration($table)->up();

        $fields = TemplateService::getFields($template);

        static::updateTable($table, $fields);

        GraphQLService::generateTemplatesSchema();
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
            CheckboxInput::class => $table->boolean($handle),
            DateInput::class => $table->date($handle),
            RichTextInput::class => $table->text($handle),
            TextInput::class => $table->string($handle),
            TimeInput::class => $table->time($handle),
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
    protected static function updateTable(string $table, Collection $fields): void
    {
        Schema::table($table, function (Blueprint $table) use ($fields)
        {
            foreach ($fields as $field)
            {
                if (!Schema::hasColumn($table->getTable(), $field->{Field::HANDLE}))
                {
                    static::addColumn($table, $field);
                }
            }
        });
    }

    #endregion
}
