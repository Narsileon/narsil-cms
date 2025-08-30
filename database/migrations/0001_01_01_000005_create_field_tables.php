<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Forms\RuleEnum;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;
use Narsil\Models\Elements\FieldRule;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(Field::TABLE))
        {
            $this->createFieldsTable();
        }
        if (!Schema::hasTable(FieldOption::TABLE))
        {
            $this->createFieldOptionsTable();
        }
        if (!Schema::hasTable(FieldRule::TABLE))
        {
            $this->createFieldRulesTable();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FieldOption::TABLE);
        Schema::dropIfExists(Field::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createFieldOptionsTable(): void
    {
        Schema::create(FieldOption::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FieldOption::ID);
            $table
                ->foreignId(FieldOption::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $table
                ->integer(FieldOption::POSITION);
            $table
                ->string(FieldOption::LABEL);
            $table
                ->string(FieldOption::VALUE);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createFieldRulesTable(): void
    {
        Schema::create(FieldRule::TABLE, function (Blueprint $table)
        {
            $table
                ->id(FieldRule::ID);
            $table
                ->foreignId(FieldRule::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $table
                ->enum(FieldRule::RULE, RuleEnum::values())
                ->default(RuleEnum::STRING->value);
        });
    }

    /**
     * @return void
     */
    private function createFieldsTable(): void
    {
        Schema::create(Field::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Field::ID);
            $table
                ->string(Field::NAME);
            $table
                ->string(Field::HANDLE);
            $table
                ->string(Field::DESCRIPTION)
                ->nullable();
            $table
                ->boolean(Field::TRANSLATABLE)
                ->default(false);
            $table
                ->string(Field::TYPE);
            $table
                ->json(Field::SETTINGS)
                ->nullable()
                ->default(null);
            $table
                ->timestamps();
        });
    }

    #endregion
};
