<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Models\User;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;
use Narsil\Cms\Models\Collections\FieldValidationRule;
use Narsil\Cms\Models\ValidationRule;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            if (!Schema::hasTable("$schema." . Field::TABLE))
            {
                $this->createFieldsTable($schema);
            }
            if (!Schema::hasTable("$schema." . FieldOption::TABLE))
            {
                $this->createFieldOptionsTable($schema);
            }
            if (!Schema::hasTable("$schema." . FieldValidationRule::TABLE))
            {
                $this->createFieldValidationRuleTable($schema);
            }
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            Schema::dropIfExists("$schema." . FieldValidationRule::TABLE);
            Schema::dropIfExists("$schema." . FieldOption::TABLE);
            Schema::dropIfExists("$schema." . Field::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the field options table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createFieldOptionsTable(string $schema): void
    {
        Schema::create("$schema." . FieldOption::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(FieldOption::UUID)
                ->primary();
            $blueprint
                ->foreignId(FieldOption::FIELD_ID)
                ->constrained("$schema." . Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(FieldOption::VALUE);
            $blueprint
                ->jsonb(FieldOption::LABEL);
            $blueprint
                ->integer(FieldOption::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the field validation rule table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createFieldValidationRuleTable(string $schema): void
    {
        Schema::create("$schema." . FieldValidationRule::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(FieldValidationRule::UUID)
                ->primary();
            $blueprint
                ->foreignId(FieldValidationRule::FIELD_ID)
                ->constrained("$schema." . Field::TABLE, Field::ID)
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
     * @param string $schema
     *
     * @return void
     */
    private function createFieldsTable(string $schema): void
    {
        Schema::create("$schema." . Field::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Field::ID);
            $blueprint
                ->string(Field::HANDLE)
                ->unique();
            $blueprint
                ->string(Field::TYPE);
            $blueprint
                ->jsonb(Field::LABEL);
            $blueprint
                ->jsonb(Field::DESCRIPTION)
                ->nullable();
            $blueprint
                ->jsonb(Field::PLACEHOLDER)
                ->nullable();
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
