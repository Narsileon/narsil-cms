<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldOption;
use Narsil\Models\Structures\FieldValidationRule;
use Narsil\Models\User;
use Narsil\Models\ValidationRule;

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
        if (!Schema::hasTable(FieldValidationRule::TABLE))
        {
            $this->createFieldValidationRuleTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FieldValidationRule::TABLE);
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
     * Create the field validation rule table.
     *
     * @return void
     */
    private function createFieldValidationRuleTable(): void
    {
        Schema::create(FieldValidationRule::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FieldValidationRule::UUID)
                ->primary();
            $blueprint
                ->foreignId(FieldValidationRule::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(FieldValidationRule::VALIDATION_RULE_ID)
                ->constrained(ValidationRule::TABLE, ValidationRule::ID)
                ->cascadeOnDelete();
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
                ->nullable();
            $blueprint
                ->jsonb(Field::PLACEHOLDER)
                ->nullable();
            $blueprint
                ->boolean(Field::REQUIRED)
                ->default(false);
            $blueprint
                ->boolean(Field::TRANSLATABLE)
                ->default(false);
            $blueprint
                ->string(Field::CLASS_NAME)
                ->nullable();
            $blueprint
                ->jsonb(Field::SETTINGS)
                ->nullable();
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
