<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Forms\RuleEnum;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;
use Narsil\Models\Elements\FieldRule;
use Narsil\Models\User;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * Run the migrations.
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
     * Reverse the migrations.
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
     * Create the field options table.
     *
     * @return void
     */
    private function createFieldOptionsTable(): void
    {
        Schema::create(FieldOption::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FieldOption::UUID)
                ->primary();
            $blueprint
                ->foreignId(FieldOption::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FieldOption::VALUE);
            $blueprint
                ->jsonb(FieldOption::LABEL);
            $blueprint
                ->integer(FieldOption::POSITION)
                ->default(0);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the field rules table.
     *
     * @return void
     */
    private function createFieldRulesTable(): void
    {
        Schema::create(FieldRule::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(FieldRule::ID);
            $blueprint
                ->foreignId(FieldRule::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->enum(FieldRule::RULE, RuleEnum::values())
                ->default(RuleEnum::STRING->value);
        });
    }

    /**
     * Create the fields table.
     *
     * @return void
     */
    private function createFieldsTable(): void
    {
        Schema::create(Field::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Field::ID);
            $blueprint
                ->string(Field::HANDLE)
                ->unique();
            $blueprint
                ->string(Field::TYPE);
            $blueprint
                ->jsonb(Field::NAME);
            $blueprint
                ->jsonb(Field::DESCRIPTION)
                ->default(new Expression('(JSON_OBJECT())'));
            $blueprint
                ->boolean(Field::TRANSLATABLE)
                ->default(false);
            $blueprint
                ->string(Field::CLASS_NAME)
                ->nullable();
            $blueprint
                ->jsonb(Field::SETTINGS)
                ->default(new Expression('(JSON_OBJECT())'));
            $blueprint
                ->timestamp(Field::CREATED_AT);
            $blueprint
                ->foreignId(Field::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Field::UPDATED_AT);
            $blueprint
                ->foreignId(Field::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
