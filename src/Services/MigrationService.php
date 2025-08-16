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
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Services\TemplateService;

#endregion

class MigrationService
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

        if (!Schema::hasTable($table))
        {
            static::createTable($table);
        }

        $fields = TemplateService::getFields($template);

        static::updateTable($table, $fields);
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
     *
     * @return void
     */
    protected static function createTable(string $table): void
    {
        Schema::create($table, function (Blueprint $table)
        {
            $table
                ->uuid(Entity::UUID)
                ->primary();
            $table
                ->bigInteger(Entity::ID)
                ->index();
            $table
                ->timestamps();
            $table
                ->softDeletes()
                ->index();
        });
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
